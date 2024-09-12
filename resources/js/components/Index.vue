<template>
    <div id="app" class="min-h-screen w-screen bg-gray-200 flex flex-col pt-20 justify-center items-center md:items-start row" >
        <div class="col-md-4">
            <div class="text-center px-3" style="background-color: #d3caca;padding: 20px;border-radius: 7px;">
                <h4 class="mb-2 text-gray-700 font-semibold font-sans tracking-wide">ACTIVO</h4>
                <draggable id="activas" tag="ul" group="all-users" class="draggable-list" ghost-class="moving-card" filter=".action-button" :list="ventasActivas" :animation="200" :move="checkMove">
                    <user-card v-for="venta in ventasActivas" :venta="venta" :key="venta.id" @on-edit="onEdit" @on-delete="onDelete" ></user-card>
                </draggable>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center px-3" style="background-color: rgb(233 230 4);padding: 20px;border-radius: 7px;">
                <h4 class="mb-2 text-gray-700 font-semibold font-sans tracking-wide">EN PROCESO</h4>
                <draggable id="proceso" tag="ul" group="all-users" class="draggable-list" ghost-class="moving-card" filter=".action-button" :list="ventasProceso" :animation="200" :move="checkMove">
                    <user-card v-for="venta in ventasProceso" :venta="venta" :key="venta.id" @on-edit="onEdit" @on-delete="onDelete" ></user-card>
                </draggable>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center px-3" style="background-color: rgb(82 197 114);padding: 20px;border-radius: 7px;">
                <h4 class="mb-2 text-gray-700 font-semibold font-sans tracking-wide">FINALIZADA</h4>
                <draggable id="finalizadas" tag="ul" group="all-users" class="draggable-list" ghost-class="moving-card" filter=".action-button" :list="ventasFinalizadas" :animation="200" :move="checkMove">
                    <user-card v-for="venta in ventasFinalizadas" :venta="venta" :key="venta.id" @on-edit="onEdit" @on-delete="onDelete" ></user-card>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable';
    export default {
        name: "Index",
        components: {
            draggable
        },
        data() {
        return {
            ventasActivas: [],
            ventasProceso: [],
            ventasFinalizadas: [],
            activeNames: ''
        }
    },
    mounted()
    {
        this.index();
    },
    methods: {
        index() 
        {
            let me = this;
            let url = '/api/indexVentas';
            axios.get(url,{

            }).then((response) => {
                if(response.data.length < 1)
                {
                    this.ventas = [];
                }
                else
                {
                    response.data.forEach((value, index) => 
                    {
                        if(value.idEstado == 58)
                        {
                            this.ventasActivas.push(value);
                        }
                        else if(value.idEstado == 59)
                        {
                            this.ventasProceso.push(value);
                        }
                        else if(value.idEstado == 60)
                        {
                            this.ventasFinalizadas.push(value);
                        }
                    });
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        onEdit(venta) 
        {
            alert(`Editing ${venta.idVenta}`);
        },
        onDelete(venta) 
        {
            alert(`Deleting ${venta.idVenta}`);
        },
        checkMove: function(evt)
        {
            let me = this;
            let url = '/api/cambiarVenta';
            axios.post(url,{
                'id': evt.draggedContext.element.idVenta,
                'estado': evt.to.id,
            }).then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });   
        }
    },
  }
</script>

<style>
    .draggable-list {
        min-height: 100px;
    }
    /* Unfortunately @apply cannot be setup in codesandbox, 
    but you'd use "@apply border opacity-50 border-blue-500 bg-gray-200" here */
    .moving-card {
        opacity: 0.5;
        background: #F7FAFC;
        border: 1px solid #4299e1;
    }
    ul {
        list-style: none !important;
        padding: 0px !important;
    }
</style>