@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Dolores"
            maxlenght="25">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" wire:model.lazy="lastname" class="form-control" placeholder="ej: Fuertes"
            maxlenght="25">
            @error('description') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Telefono</label>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="ej: #######"
            maxlenght="25">
            @error('description') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej: doloresfuertes@gmail.com"
            maxlenght="25">
            @error('description') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" wire:model.lazy="password" class="form-control" placeholder="ej: ****************"
            maxlenght="25">
            @error('description') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select wire:model.lazy='condition' class="form-control">
                <option defauld="true">---</option>
                <option value="active">Activo</option>
                <option value="inactive">Incativo</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Rol</label>
            <select wire:model.lazy='role' class="form-control">
                <option defauld="true">---</option>
                <option value="admin">admin</option>
                <option value="employee">employee</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Cargo</label>
            <select wire:model='position_id' class="form-control">
                <option value="{{$position_id}}" disabled selected>{{}}</option>
                    @foreach ($posis as $cargo)
                        <option value="{{ $cargo->id }}">{{ $cargo->name }}</option>
                    @endforeach
            </select>
        </div>
    </div>
</div> 


@include('common.modalFooter')


