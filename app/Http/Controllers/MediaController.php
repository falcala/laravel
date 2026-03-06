<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /** Root folder inside public/ */
    private string $base = 'assets';

    private array $imageExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    private array $docExts   = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'zip'];

    // ── Path helpers ──────────────────────────────────────────────────────

    /**
     * Sanitize a user-provided relative path.
     * Strips ../, backslashes, null bytes, and empty segments.
     */
    private function cleanPath(string $path): string
    {
        $parts = explode('/', str_replace(['\\', "\0"], '/', $path));
        $safe  = array_filter($parts, fn($p) => $p !== '' && $p !== '.' && $p !== '..');
        return implode('/', $safe);
    }

    /** Absolute filesystem path for a relative sub-path (inside base). */
    private function absPath(string $rel = ''): string
    {
        $base = public_path($this->base);
        return $rel === '' ? $base : $base . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
    }

    /** Public URL for a file inside base. */
    private function toUrl(string $rel, string $filename): string
    {
        $path = $rel !== '' ? $rel . '/' . $filename : $filename;
        return asset($this->base . '/' . $path);
    }

    /** Ensure the root assets/ folder exists. */
    private function ensureBase(): void
    {
        $path = public_path($this->base);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    // ── Full media manager page ───────────────────────────────────────────
    public function manager()
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);
        $this->ensureBase();
        return view('content.media.index');
    }

    // ── Folder tree (recursive, max 6 levels deep) ───────────────────────
    public function tree()
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);
        $this->ensureBase();
        return response()->json([
            'name'     => 'assets',
            'path'     => '',
            'children' => $this->buildTree('', 0),
        ]);
    }

    private function buildTree(string $rel, int $depth): array
    {
        if ($depth > 6) return [];
        $result = [];
        foreach (File::directories($this->absPath($rel)) as $dir) {
            $name   = basename($dir);
            $subRel = $rel !== '' ? $rel . '/' . $name : $name;
            $result[] = [
                'name'     => $name,
                'path'     => $subRel,
                'children' => $this->buildTree($subRel, $depth + 1),
            ];
        }
        return $result;
    }

    // ── List files in a folder ────────────────────────────────────────────
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);

        $rel        = $this->cleanPath($request->query('path', ''));
        $typeFilter = $request->query('type', 'all');
        $absDir     = $this->absPath($rel);
        $files      = [];

        $folders = [];

        if (File::exists($absDir) && is_dir($absDir)) {
            // Include sub-directories as folder entries when requested
            if ($request->query('include_dirs') && $typeFilter === 'all') {
                foreach (File::directories($absDir) as $dir) {
                    $name   = basename($dir);
                    $subRel = $rel !== '' ? $rel . '/' . $name : $name;
                    $folders[] = [
                        'type'     => 'folder',
                        'name'     => $name,
                        'path'     => $subRel,
                        'url'      => null,
                        'ext'      => '',
                        'size'     => 0,
                        'modified' => filemtime($dir),
                    ];
                }
                usort($folders, fn($a, $b) => strcmp($a['name'], $b['name']));
            }

            foreach (File::files($absDir) as $file) {
                $ext  = strtolower($file->getExtension());
                $type = in_array($ext, $this->imageExts) ? 'image'
                      : (in_array($ext, $this->docExts)  ? 'document' : null);
                if (!$type) continue;
                if ($typeFilter === 'images'    && $type !== 'image')    continue;
                if ($typeFilter === 'documents' && $type !== 'document') continue;

                $files[] = [
                    'url'      => $this->toUrl($rel, $file->getFilename()),
                    'name'     => $file->getFilename(),
                    'ext'      => $ext,
                    'type'     => $type,
                    'size'     => $file->getSize(),
                    'modified' => $file->getMTime(),
                    'path'     => $rel,
                ];
            }
            usort($files, fn($a, $b) => $b['modified'] - $a['modified']);
        }

        return response()->json(array_merge($folders, $files));
    }

    // ── Upload file ───────────────────────────────────────────────────────
    public function upload(Request $request)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);

        $allowed = implode(',', array_merge($this->imageExts, $this->docExts));
        $request->validate([
            'file' => 'required|file|mimes:' . $allowed . '|max:10240',
            'path' => 'nullable|string|max:500',
        ]);

        $rel  = $this->cleanPath($request->input('path', ''));
        $dest = $this->absPath($rel);

        if (!File::exists($dest)) {
            File::makeDirectory($dest, 0755, true);
        }

        $file     = $request->file('file');
        $ext      = strtolower($file->getClientOriginalExtension());
        $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = time() . '_' . $baseName . '.' . $ext;

        $file->move($dest, $filename);

        $type = in_array($ext, $this->imageExts) ? 'image' : 'document';

        return response()->json([
            'success'  => true,
            'url'      => $this->toUrl($rel, $filename),
            'name'     => $filename,
            'ext'      => $ext,
            'type'     => $type,
            'size'     => filesize($dest . DIRECTORY_SEPARATOR . $filename),
            'modified' => time(),
            'path'     => $rel,
        ]);
    }

    // ── Rename file ───────────────────────────────────────────────────────
    public function rename(Request $request)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);

        $request->validate([
            'old_name' => 'required|string|max:255',
            'new_name' => 'required|string|max:200',
            'path'     => 'nullable|string|max:500',
        ]);

        $rel     = $this->cleanPath($request->input('path', ''));
        $oldName = basename($request->old_name);
        $oldPath = $this->absPath($rel) . DIRECTORY_SEPARATOR . $oldName;

        if (!File::exists($oldPath)) {
            return response()->json(['success' => false, 'message' => 'Archivo no encontrado'], 404);
        }

        $ext     = strtolower(pathinfo($oldName, PATHINFO_EXTENSION));
        $newBase = Str::slug(pathinfo($request->new_name, PATHINFO_FILENAME));
        if (!$newBase) {
            return response()->json(['success' => false, 'message' => 'Nombre inválido'], 422);
        }

        $newName = $newBase . '.' . $ext;
        $newPath = $this->absPath($rel) . DIRECTORY_SEPARATOR . $newName;
        if (File::exists($newPath) && $newPath !== $oldPath) {
            $newName = $newBase . '_' . time() . '.' . $ext;
            $newPath = $this->absPath($rel) . DIRECTORY_SEPARATOR . $newName;
        }

        File::move($oldPath, $newPath);

        return response()->json([
            'success'  => true,
            'new_name' => $newName,
            'new_url'  => $this->toUrl($rel, $newName),
        ]);
    }

    // ── Delete file ───────────────────────────────────────────────────────
    public function destroy(Request $request)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'nullable|string|max:500',
        ]);

        $rel  = $this->cleanPath($request->input('path', ''));
        $name = basename($request->name);
        $path = $this->absPath($rel) . DIRECTORY_SEPARATOR . $name;

        if (!File::exists($path) || is_dir($path)) {
            return response()->json(['success' => false, 'message' => 'Archivo no encontrado'], 404);
        }

        File::delete($path);
        return response()->json(['success' => true]);
    }

    // ── Create folder ─────────────────────────────────────────────────────
    public function createFolder(Request $request)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);

        $request->validate([
            'name' => 'required|string|max:100',
            'path' => 'nullable|string|max:500',
        ]);

        $rel  = $this->cleanPath($request->input('path', ''));
        $name = Str::slug($request->input('name'));

        if (!$name) {
            return response()->json(['success' => false, 'message' => 'Nombre inválido'], 422);
        }

        $newRel  = $rel !== '' ? $rel . '/' . $name : $name;
        $newPath = $this->absPath($newRel);

        if (File::exists($newPath)) {
            return response()->json(['success' => false, 'message' => 'La carpeta ya existe'], 409);
        }

        File::makeDirectory($newPath, 0755, true);

        return response()->json(['success' => true, 'name' => $name, 'path' => $newRel]);
    }

    // ── Delete folder ─────────────────────────────────────────────────────
    public function deleteFolder(Request $request)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);

        $request->validate(['path' => 'required|string|max:500']);

        $rel = $this->cleanPath($request->input('path'));
        if ($rel === '') {
            return response()->json(['success' => false, 'message' => 'No se puede eliminar la carpeta raíz'], 422);
        }

        $path = $this->absPath($rel);
        if (!is_dir($path)) {
            return response()->json(['success' => false, 'message' => 'Carpeta no encontrada'], 404);
        }

        File::deleteDirectory($path);
        return response()->json(['success' => true]);
    }
}
