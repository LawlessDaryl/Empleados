@include('common.modalHeadEmployee')


<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">

                    </span>
                </span>
            </div>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: master chief">
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej: epic@gmail.com">
            <input type="text" wire:model.lazy="password" class="form-control" placeholder="ej: ***">
            <input type="text" wire:model.lazy="condition" class="form-control" placeholder="ej: activo - incativo">
            <input type="text" wire:model.lazy="person_id" class="form-control" placeholder="ej: 1">
            
        </div>
        @error('name') <span class="text danger er">{{$message}}</span>@enderror
        @error('email') <span class="text danger er">{{$message}}</span>@enderror
        @error('password') <span class="text danger er">{{$message}}</span>@enderror
        @error('condition') <span class="text danger er">{{$message}}</span>@enderror
        @error('person_id') <span class="text danger er">{{$message}}</span>@enderror
    </div>
    <!--<div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image" accept="image/x-png, image/gif, image/jpeg ">
            <label class="custom-file-label">Imagen{{$image}}</label>
            @error('image') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>-->
</div>

@include('common.modalFooterEmployee')