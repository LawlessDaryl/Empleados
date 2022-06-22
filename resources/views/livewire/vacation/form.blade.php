@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Rango minimo</label>
            <input type="text" wire:model.lazy="minimum_years" class="form-control" placeholder="ej: años"
            maxlenght="25">
            @error('minimum_years') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Rango maximo</label>
            <input type="text" wire:model.lazy="maximum_years" class="form-control" placeholder="ej: años"
            maxlenght="25">
            @error('maximum_years') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Dias Asignados</label>
            <input type="text" wire:model.lazy="free_days" class="form-control" placeholder="ej: dias"
            maxlenght="25">
            @error('free_days') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Observaciones</label>
            <input type="text" wire:model.lazy="observation" class="form-control" placeholder="Comentario"
            maxlenght="25">
            @error('observation') <span class="text-danger er">{{ $message }}</span>@enderror
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