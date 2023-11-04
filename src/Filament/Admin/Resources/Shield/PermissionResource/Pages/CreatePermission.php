<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\Shield\PermissionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Collection;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\Shield\PermissionResource;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;

    public Collection $permissions;

    //    protected function mutateFormDataBeforeCreate(array $data): array
    //    {
    //        $this->permissions = collect($data)->filter(function ($permission, $key) {
    //            return ! in_array($key, ['name', 'guard_name', 'select_all']) && Str::contains($key, '_');
    //        })->keys();
    //
    //        return Arr::only($data, ['name', 'guard_name']);
    //    }
    //
    //    protected function afterCreate(): void
    //    {
    //        $permissionModels = collect();
    //        $this->permissions->each(function ($permission) use ($permissionModels) {
    //            $permissionModels->push(Utils::getPermissionModel()::firstOrCreate(
    //                /** @phpstan-ignore-next-line */
    //                ['name' => $permission],
    //                ['guard_name' => $this->data['guard_name']]
    //            ));
    //        });
    //
    //        $this->record->syncPermissions($permissionModels);
    //    }
}
