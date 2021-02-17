<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <i class="fas fa-file-alt"></i> Sites
    </h2>
</x-slot>

<div class="container mx-auto px-4 mt-8">
    <a class="link-style" href="">
        + Criar Novo Site
    </a>

    <p class="meus-sites">
        <span><img src="{{ asset('img/icon open-browser.png')  }}" /></span>
        Meus Sites
    </p>

    <input type="text" wire:model="search" />
    {{ $search  }}
    <div class="mt-8">
        <div class="w-full rounded overflow-hidden">
            <ul>
                <li class="shadow-lg bg-white">
                    <div style="display:inline-flex;">
                        <img src="/img/test/img1.png" alt="">
                        <div class="flex flex-wrap -mb-4">
                            <div class="flex-1 h-12">
                                <p>Site Name</p>
                                <div>
                                    <p>http://ouua.multiscreensite.com</p>
                                    <p>Data criação: 12/10/2020 15:15</p>
                                    <p>Última atualização: 13/10/2020 13:52</p>
                                </div>
                            </div>
                            <div class="flex-1 h-12 px-6">
                                <p>Status: Não Publicado</p>
                                <p>Licença: Trial - 10 dias restantes</p>
                            </div>
                            <div class="flex-1 h-12 px-6">
                                dsfasd
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
