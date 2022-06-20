@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre del departamento</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Sistemas"
            maxlenght="25">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Descripción</label>
            <input type="text" wire:model.lazy="description" class="form-control" placeholder="ej: 1000"
            maxlenght="25">
            @error('description') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    
</div> 


@include('common.modalFooter')



{{-- <form>
    <div class="form-group">
        <label for="recipient-name" class="col-form-label">Recipient:</label>
        <input type="text" class="form-control" value="Creative Tim" id="recipient-name">
    </div>
    <div class="form-group">
        <label for="message-text" class="col-form-label">Message:</label>
        <textarea class="form-control" id="message-text"></textarea>
    </div>
</form> --}}