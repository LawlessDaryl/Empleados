@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Años minimo</label>
            <input type="text" wire:model.lazy="minimum" class="form-control" placeholder="ej: 2"
            maxlenght="25">
            @error('minimum') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Años maximo/label>
            <input type="text" wire:model.lazy="maximum" class="form-control" placeholder="ej: 4"
            maxlenght="25">
            @error('maximum') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Porcentaje de descuento</label>
            <input type="text" wire:model.lazy="percentage" class="form-control" placeholder="ej: 5"
            maxlenght="25">
            @error('percentage') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Observaciones</label>
            <input type="text" wire:model.lazy="observation" class="form-control" placeholder="ej: art."
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