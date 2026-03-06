@php
  $c          = $section->content ?? [];
  $bgColor    = $c['bg_color']    ?? '#696cff';
  $textColor  = $c['text_color']  ?? '#ffffff';
  $btnLabel   = $c['btn_label']   ?? 'Guardar Contacto';
  $firstName  = $c['first_name']  ?? '';
  $lastName   = $c['last_name']   ?? '';
  $fullName   = trim("{$firstName} {$lastName}");
  $initials   = strtoupper(substr($firstName,0,1) . substr($lastName,0,1));
  $downloadUrl= route('vcard.download', $section->id);
@endphp

<section style="background-color:{{ $bgColor }}" class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7">

        {{-- Card --}}
        <div class="rounded-4 overflow-hidden shadow-lg" style="background:rgba(255,255,255,.1);backdrop-filter:blur(8px)">

          {{-- Header band --}}
          <div class="p-4 d-flex align-items-center gap-4">

            {{-- Avatar --}}
            @if(!empty($c['photo_url']))
              <img src="{{ $c['photo_url'] }}" alt="{{ $fullName }}"
                   class="rounded-circle flex-shrink-0"
                   style="width:80px;height:80px;object-fit:cover;border:3px solid rgba(255,255,255,.5)">
            @else
              <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                   style="width:80px;height:80px;font-size:1.8rem;color:{{ $bgColor }};background:#fff;border:3px solid rgba(255,255,255,.5)">
                {{ $initials ?: '?' }}
              </div>
            @endif

            {{-- Name & title --}}
            <div>
              <h3 class="mb-0 fw-bold" style="color:{{ $textColor }}">{{ $fullName }}</h3>
              @if(!empty($c['title']))
                <div style="color:{{ $textColor }};opacity:.85;font-size:.95rem">{{ $c['title'] }}</div>
              @endif
              @if(!empty($c['organization']))
                <div style="color:{{ $textColor }};opacity:.7;font-size:.85rem">
                  <i class="bx bx-buildings me-1"></i>{{ $c['organization'] }}
                </div>
              @endif
            </div>
          </div>

          {{-- Contact details --}}
          <div class="px-4 pb-3" style="border-top:1px solid rgba(255,255,255,.2)">

            @php
              $details = [
                ['icon'=>'bx-mobile',   'label'=>'Celular',  'value'=>$c['phone_mobile']??'', 'href'=>'tel:'],
                ['icon'=>'bx-phone',    'label'=>'Trabajo',  'value'=>$c['phone_work']??'',   'href'=>'tel:'],
                ['icon'=>'bx-envelope', 'label'=>'Email',    'value'=>$c['email']??'',         'href'=>'mailto:'],
                ['icon'=>'bx-globe',    'label'=>'Web',      'value'=>$c['website']??'',       'href'=>''],
              ];
            @endphp

            @foreach($details as $d)
              @if(!empty($d['value']))
              <div class="d-flex align-items-center gap-3 py-2"
                   style="border-bottom:1px solid rgba(255,255,255,.1)">
                <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                     style="width:36px;height:36px;background:rgba(255,255,255,.2)">
                  <i class="bx {{ $d['icon'] }}" style="color:{{ $textColor }};font-size:1.1rem"></i>
                </div>
                <div>
                  <div style="color:{{ $textColor }};opacity:.6;font-size:.7rem;text-transform:uppercase;letter-spacing:.05em">
                    {{ $d['label'] }}
                  </div>
                  @if($d['href'])
                    <a href="{{ $d['href'] }}{{ $d['value'] }}"
                       style="color:{{ $textColor }};text-decoration:none;font-size:.9rem"
                       target="{{ $d['href']==='' ? '_blank' : '' }}">
                      {{ $d['value'] }}
                    </a>
                  @else
                    <a href="{{ $d['value'] }}" target="_blank"
                       style="color:{{ $textColor }};text-decoration:none;font-size:.9rem">
                      {{ $d['value'] }}
                    </a>
                  @endif
                </div>
              </div>
              @endif
            @endforeach

            {{-- Address --}}
            @php
              $addrParts = array_filter([$c['address']??'', $c['city']??'', $c['state']??'', $c['zip']??'', $c['country']??'']);
            @endphp
            @if(count($addrParts))
            <div class="d-flex align-items-center gap-3 py-2"
                 style="border-bottom:1px solid rgba(255,255,255,.1)">
              <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                   style="width:36px;height:36px;background:rgba(255,255,255,.2)">
                <i class="bx bx-map" style="color:{{ $textColor }};font-size:1.1rem"></i>
              </div>
              <div>
                <div style="color:{{ $textColor }};opacity:.6;font-size:.7rem;text-transform:uppercase;letter-spacing:.05em">Dirección</div>
                <span style="color:{{ $textColor }};font-size:.9rem">{{ implode(', ', $addrParts) }}</span>
              </div>
            </div>
            @endif

          </div>

          {{-- Social links --}}
          @php
            $socials = [
              'linkedin'  => ['icon'=>'bxl-linkedin',  'label'=>'LinkedIn'],
              'twitter'   => ['icon'=>'bxl-twitter',   'label'=>'Twitter'],
              'instagram' => ['icon'=>'bxl-instagram',  'label'=>'Instagram'],
            ];
            $hasSocials = array_filter(array_intersect_key($c, $socials));
          @endphp
          @if($hasSocials)
          <div class="px-4 py-3 d-flex gap-3 flex-wrap" style="border-top:1px solid rgba(255,255,255,.2)">
            @foreach($socials as $key => $s)
              @if(!empty($c[$key]))
              <a href="{{ $c[$key] }}" target="_blank"
                 class="d-flex align-items-center gap-1"
                 style="color:{{ $textColor }};text-decoration:none;font-size:.85rem;opacity:.85">
                <i class="bx {{ $s['icon'] }} fs-5"></i>{{ $s['label'] }}
              </a>
              @endif
            @endforeach
          </div>
          @endif

          {{-- Download button --}}
          <div class="p-4" style="border-top:1px solid rgba(255,255,255,.2)">
            <a href="{{ $downloadUrl }}"
               class="btn w-100 fw-semibold"
               style="background:#fff;color:{{ $bgColor }};border:none;border-radius:50px;padding:.65rem 1.5rem;transition:opacity .2s"
               onmouseover="this.style.opacity='.85'"
               onmouseout="this.style.opacity='1'">
              <i class="bx bx-download me-2 fs-5 align-middle"></i>{{ $btnLabel }}
            </a>
            <p class="text-center mb-0 mt-2" style="color:{{ $textColor }};opacity:.55;font-size:.75rem">
              Compatible con iPhone, Android y Outlook
            </p>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
