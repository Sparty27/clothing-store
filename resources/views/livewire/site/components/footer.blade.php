<div class="bg-primary min-h-[300px] mt-12">
    <div class="mx-auto container">
        <footer class="footer text-white px-20 pt-9 pb-6 md:pb-0 max-md:justify-center">
            <aside>
                <a href='{{ route('index') }}' class="w-[100px] md:w-[200px]">
                    <img src="/img/svg/logo.svg" alt="search">
                </a>
                <p>
                    LNTU Thesis
                    <br />
                    Demonstrating project
                </p>
            </aside>
            <nav>
                <h6 class="footer-title">Категорії</h6>
                @foreach ($footerCategories as $category)
                    {{-- TODO --}}
                    <a class="link-hover" href="{{ route('index', $category->slug) }}">{{ $category->name }}</a>
                    {{-- <a class="link" href="{{ route('catalog', $category->slug) }}">{{ $category->name }}</a> --}}
                @endforeach
            </nav>
            <nav>
              <h6 class="footer-title">Меню</h6>
              <a class="link link-hover" href="{{ route('index') }}">Головна</a>
              <a class="link link-hover" href="{{ route('catalog') }}">Каталог</a>
              <a class="link link-hover" href="{{ route('about') }}">Про нас</a>
            </nav>
            <div>
                <nav>
                    <h6 class="footer-title">Контакти</h6>
                    <div class="flex-col flex gap-4">
                        @foreach($footerContacts as $contact)
                            @switch($contact->type->value)
                                @case('phone')
                                    <a class="link-hover" href="tel:{{ $contact->data['phone'] }}">
                                        <i class="ri-phone-line"></i>
                                        {{ $contact->data['phone'] }}
                                    </a>
                                    @break
                            
                                @case('email')
                                    <a class="link-hover" href="mailto:{{ $contact->data['email'] }}">
                                        <i class="ri-mail-line"></i>
                                        {{ $contact->data['email'] }}
                                    </a>
                                    @break

                                @case('address')
                                    <a class="link-hover" href="https://www.google.com/maps?q={{ $contact->data['coordinates'] }}" target="_blank">
                                        <i class="ri-map-2-line"></i>
                                        {{ $contact->data['address'] }}
                                    </a>
                                    @break
                            @endswitch
                        @endforeach
                    </div>
                </nav>
                <nav class="">
                  <div class="grid grid-flow-col gap-4">
                    <a href="https://github.com/Sparty27" target=”_blank”>
                        <i class="ri-github-fill text-3xl"></i>
                    </a>
                    <a href="https://t.me/Sparty54" target=”_blank”>
                        <i class="ri-telegram-fill text-3xl"></i>
                    </a>
                  </div>
                </nav>
            </div>
        </footer>
    </div>
</div>