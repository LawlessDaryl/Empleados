<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">                    
                        <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Agregar</a>                    
                </ul>
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe">Nombre usuario</th>
                                <th class="table-th text-withe text-center">Email</th>
                                <th class="table-th text-withe text-center">Password</th>
                                <th class="table-th text-withe text-center">Condition</th>
                                <th class="table-th text-withe text-center">Persona_id</th>
                                
                                <th class="table-th text-withe text-center">Acciones</th>
      
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $empleado)
                                <tr>
                                    <td>
                                        <h6>{{ $empleado->user_name }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $empleado->email }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $empleado->password }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $empleado->condition }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $empleado->person_id }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $empleado->empleado_id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $product->id }}','{{ $product->name }}')" class="btn btn-dark"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.products.form')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('product-deleted', msg => {
            ///
        });
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display','none')
        });
    });
    function Confirm(id, name, products) {
        if (products > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el producto, ' + name + ' porque tiene ' 
                + products + ' ventas relacionadas'
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