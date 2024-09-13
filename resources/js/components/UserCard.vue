<template>
    <li class="flex justify-between items-center bg-white border border-white shadow rounded-lg cursor-move" style="margin-bottom: 10px;">
        <!--<div class="flex items-center">
            <img class="w-10 h-10 rounded-full" :src="venta.avatar" :alt="venta.direccion">
            <p class="ml-2 text-gray-700 font-semibold font-sans tracking-wide">{{venta.direccion}}</p>
        </div>
        <div class="flex">
            <button aria-label="Edit" class="action-button p-1 focus:outline-none focus:shadow-outline text-teal-500 hover:text-teal-600" @click="$emit('on-edit', venta)" >
                <EditIcon/>
            </button>
            <button aria-label="Delete" class="action-button p-1 focus:outline-none focus:shadow-outline text-red-500 hover:text-red-600" @click="$emit('on-delete', venta)">
                <Trash2Icon/>
            </button>
            <a :href="'/ventas/edit/' + venta.idVenta" aria-label="Edit" class="button p-1 focus:outline-none focus:shadow-outline text-teal-500 hover:text-teal-600">
                <EditIcon/>
            </a>
        </div>-->
        <div class="card task-box" style="margin-bottom: 0px !important; border: none !important;">
            <div class="card-body">
                <div class="float-right ml-2">
                    <span class="badge badge-pill badge-soft-primary font-size-12" v-if="venta.idEstado == 58">PLANIFICADO</span>
                    <span class="badge badge-pill badge-soft-secondary font-size-12" v-if="venta.idEstado == 59">PROCESO</span>
                    <span class="badge badge-pill badge-soft-success font-size-12" v-if="venta.idEstado == 60">FINALIZADO</span>
                    <a :href="'/ventas/edit/' + venta.idVenta" aria-label="Edit" class="button p-1 focus:outline-none focus:shadow-outline text-teal-500 hover:text-teal-600">
                        <EditIcon/>
                    </a>
                </div>
                <div>
                    <h5 class="font-size-15" style="text-align: left;"><a href="javascript: void(0);" class="text-dark">{{ venta.direccion }} {{ venta.numero }} DPTO: {{ venta.block }}</a></h5>
                    <p class="text-muted" style="text-align: left; margin-bottom: 0px !important;">{{ venta.nombreComprador }} {{ venta.apellidoComprador }}</p>
                </div>
                <div class="team float-left">
                    <a href="javascript: void(0);" class="team-member d-inline-block" :title="`${ venta.name }`">
                        <img :src="'/img/usuarios/' + venta.avatarImg" class="rounded-circle avatar-xs m-1" :alt="`${ venta.name }`">
                    </a>
                </div>
                <div class="text-right">
                    <h5 class="font-size-15 mb-1">UF {{ venta.precioVenta | miles }}</h5>
                    <p class="mb-0 text-muted">INICIO: {{ venta.fechaInicio | formatDate }}</p>
                </div>
            </div>
            
        </div>
    </li>
</template>
<script>
    import { EditIcon, Trash2Icon } from "vue-feather-icons";
    export default {
        components: {
            EditIcon,
            Trash2Icon
        },
        props: {
            venta: {
                type: Object,
                default: () => ({})
        },
        methods: {
            formatPrice(value) {
                var formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'PHP',
                    minimumFractionDigits: 2
                });
                return formatter.format(value);
            },
        }
    },
  }
</script>