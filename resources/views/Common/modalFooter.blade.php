
                
            </div>

            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
                
                @if($selected_id < 1)
                    <button type="button" wire:click.prevent="Store()" class="btn bg-gradient-primary close-modal">Guardar</button>
                @else
                    <button type="button" wire:click.prevent="Update()" class="btn bg-gradient-primary close-modal">Guardar</button>
                @endif
            </div>
        </div>
    </div>
</div>


