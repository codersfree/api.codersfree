<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>



    <x-container id="app" class="py-8">

        <x-form-section class="mb-12">

            <x-slot name="title">
                Crea un nuevo cliente
            </x-slot>

            <x-slot name="description">
                Ingrese los datos solicitados para poder crear un nuevo cliente
            </x-slot>

            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-4">

                    <div v-if="createForm.errors.length > 0"
                        class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <strong class="font-bold">Whoops!</strong>
                        <span>¡Algo salio mal!</span>

                        <ul>
                            <li v-for="error in createForm.errors">
                                @{{ error }}
                            </li>
                        </ul>
                    </div>

                    <x-label>
                        Nombre
                    </x-label>

                    <x-input v-model="createForm.name" type="text" class="w-full mt-1" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-label>
                        URL de redirección
                    </x-label>

                    <x-input v-model="createForm.redirect" type="text" class="w-full mt-1" />
                </div>
            </div>

            <x-slot name="actions">
                <x-button v-on:click="store" v-bind:disabled="createForm.disabled">
                    Crear
                </x-button>
            </x-slot>
        </x-form-section>

        <x-form-section v-if="clients.length > 0">

            <x-slot name="title">
                Lista de clientes
            </x-slot>

            <x-slot name="description">
                Aquí podrás encontrar todos los clientes que has agregado
            </x-slot>

            <div>

                <table class="text-gray-600">
                    <thead class="border-b border-gray-300">
                        <tr class="text-left">
                            <th class="py-2 w-full">Nombre</th>
                            <th class="py-2">Acción</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-300">
                        <tr v-for="client in clients">
                            <td class="py-2">
                                @{{ client . name }}
                            </td>

                            <td class="flex divide-x divide-gray-300 py-2">
                                <a class="pr-2 hover:text-blue-600 font-semibold cursor-pointer">
                                    Editar
                                </a>

                                <a class="pl-2 hover:text-red-600 font-semibold cursor-pointer"
                                    v-on:click="destroy(client)">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>


        </x-form-section>

    </x-container>

    @push('js')

        <script>
            new Vue({
                el: "#app",
                data: {
                    clients: [],
                    createForm: {
                        errors: [],
                        disabled: false,
                        errors: [],
                        name: null,
                        redirect: null,
                    }
                },
                mounted() {
                    this.getClients();
                },
                methods: {
                    getClients() {
                        axios.get('/oauth/clients')
                            .then(response => {
                                this.clients = response.data
                            });
                    },
                    store() {

                        this.createForm.disabled = true;

                        axios.post('/oauth/clients', this.createForm)
                            .then(response => {
                                this.createForm.name = null;
                                this.createForm.redirect = null;
                                Swal.fire(
                                    '¡Creado con éxito!',
                                    'El cliente se creó satisfactoriamente.',
                                    'success'
                                );

                                this.getClients();

                                this.createForm.disabled = false;

                            }).catch(error => {

                                this.createForm.errors = _.flatten(_.toArray(error.response.data.errors));

                                this.createForm.disabled = false;

                            })
                    },

                    destroy(client) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                axios.delete('/oauth/clients/' + client.id)
                                    .then(response => {
                                        this.getClients();
                                    });

                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }
                        })
                    }
                }
            });
        </script>

    @endpush

</x-app-layout>
