@php
    $menu = [
        [
            'heading' => 'Platform',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'icon' => 'home',
                    'permission' => null,
                ],
            ],
        ],
        [
            'heading' => 'User Management',
            'items' => [
                [
                    'label' => 'Users',
                    'route' => 'user-management.users.index',
                    'icon' => 'users',
                    'permission' => 'users.view',
                ],
                [
                    'label' => 'Roles',
                    'route' => 'user-management.roles.index',
                    'icon' => 'shield-check',
                    'permission' => 'roles.view',
                ],
            ],
        ],
    ];
@endphp

<flux:navlist variant="outline">
    @foreach ($menu as $group)
        @php
            $visibleItems = collect($group['items'])->filter(function ($item) {
                return is_null($item['permission']) || auth()->user()->can($item['permission']);
            });
        @endphp

        @if ($visibleItems->isNotEmpty())
            <flux:navlist.group heading="{{ __($group['heading']) }}">
                @foreach ($visibleItems as $item)
                    @php
                        // Extraer el prefijo para que cubra todas las rutas relacionadas
                        $routePrefix = Str::beforeLast($item['route'], '.');
                        $isActive = request()->routeIs($routePrefix . '.*');
                    @endphp

                    <flux:navlist.item href="{{ route($item['route']) }}" :current="$isActive"
                        icon="{{ $item['icon'] }}" wire:navigate>
                        {{ __($item['label']) }}
                    </flux:navlist.item>
                @endforeach
            </flux:navlist.group>
        @endif
    @endforeach
</flux:navlist>
