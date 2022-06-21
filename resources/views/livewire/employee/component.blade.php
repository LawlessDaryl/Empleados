<div class="row">
    <div class="col-12">
        <div class="card mb-4">            
            <div class="card-header p-4">
                <div class="row">
                    <h4 class="">
                        <b>{{ $componentName }} | {{ $pageTitle }}</b>
                    </h4>
                </div>
            </div>
            <div class="p-3 justify-content-between d-flex">
                @include('common.searchbox')
            
                <ul class="tabs tab-pills">                    
                    <a href="javascript:void(0)" class="btn bg-gradient-primary" wire:click="Agregar()">Agregar</a>                    
                </ul>
            </div>
            <div class="card">
                <div class="table-responsive p-2">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text font-weight-bold ps-2">Nombre</th>
                                <th class="text-uppercase text-secondary text font-weight-bold ps-2">Apellido</th>
                                <th class="text-uppercase text-secondary text-center">Telefono</th>
                                <th class="text-uppercase text-secondary text-center">Email</th>                                
                                <th class="text-uppercase text-secondary text-center">Estado</th>
                                <th class="text-uppercase text-secondary text-center">Desc. Rol</th>                                

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $emp)
                                <tr>
                                    <td>
                                        <p class="text-x font-weight-regular opacity-8 mb-0">{{ $emp->username }}</p>
                                    </td>

                                    <td>
                                        <p class="text-x font-weight-regular opacity-8 mb-0">{{ $emp->lastname }}</p>
                                    </td>
                                    <td>
                                        <p class="text-x font-weight-regular opacity-8 mb-0">{{ $emp->phone }}</p>
                                    </td>
                                    <td>
                                        <p class="text-x font-weight-regular opacity-8 mb-0">{{ $emp->email }}</p>
                                    </td>                                    
                                    <td>
                                        <p class="text-x font-weight-regular opacity-8 mb-0">{{ $emp->condition }}</p>
                                    </td>
                                    <td>
                                        <p class="text-x font-weight-regular opacity-8 mb-0">{{ $emp->posiname }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $emp->id }})"
                                            class="btn bg-primary text-white mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $emp->id }}','{{ $emp->name }}')" 
                                            class="btn bg-primary text-white mtmobile"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>       

            pagination

        </div>
    </div>
    @include('livewire.departments.form')

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide'),
            noty(msg)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });
    });

    function Confirm(id, name) {
        if (items > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar la procedencia, ' + name + ' porque tiene ' +
                    items + ' clientes relacionados'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el prouducto ' + '"' + name + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>