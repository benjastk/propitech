<template>
    <li class="p-4 mb-3 flex justify-between items-center bg-white border border-white shadow rounded-lg cursor-move" >
        <div class="flex items-center">
            <img class="w-10 h-10 rounded-full" :src="venta.avatar" :alt="venta.direccion">
            <p class="ml-2 text-gray-700 font-semibold font-sans tracking-wide">{{venta.direccion}}</p>
        </div>
        <div class="flex">
            <!--<button aria-label="Edit" class="action-button p-1 focus:outline-none focus:shadow-outline text-teal-500 hover:text-teal-600" @click="$emit('on-edit', venta)" >
                <EditIcon/>
            </button>
            <button aria-label="Delete" class="action-button p-1 focus:outline-none focus:shadow-outline text-red-500 hover:text-red-600" @click="$emit('on-delete', venta)">
                <Trash2Icon/>
            </button>-->
            <a :href="'/ventas/edit/' + venta.idVenta" aria-label="Edit" class="button p-1 focus:outline-none focus:shadow-outline text-teal-500 hover:text-teal-600">
                <EditIcon/>
            </a>
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
        }
    },
  }
</script>