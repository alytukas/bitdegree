<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { onBeforeUnmount, ref, onMounted } from 'vue';
import $ from "jquery";
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';
import 'datatables.net-bs4';

// let myTable: DataTables.Api | undefined;

const myTable = ref<DataTables.Api | null>(null);
const isLoading = ref(false);

onMounted(() => {
    myTable.value = $('#myTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "api/crypto/list",
        "columns": [ 
            { "data": "id" },
            { "data": "name" },
            { "data": "price" },
            { "data": "market_cap" },
            { "data": "volume_24h" },
            { "data": "volume_change_24h", render: function (data, type, row) {
            if (type === "display") {
                return data + "%";
            }
            return data;
            }},
            { "data": "last_updated", 
            render: function (data, type, row) {
            const date = new Date(data);
            const options = {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
                hour: "2-digit",
                minute: "2-digit",
                // second: "2-digit",
                hour12: false,
            };
            return date.toLocaleString(undefined, options);
        } },  
        ],
        "language": {
            "search": "Paieška:",
            "lengthMenu": "Rodyti _MENU_ įrašų",
            "info": "rodoma: _START_ iš _END_ iš viso _TOTAL_",
            "infoEmpty": "Įrašų niera",
            "emptyTable": "Duomenų bazėje įrašų niera",
            "paginate": {
                "first": "Pirmas",
                "last": "Paskutinis",
                "next": "Sekantis", // Change this line for "Next" button
                "previous": "Praeitas" // Change this line for "Previous" button
            }
        }
    });
});

const fetchData = async () => {
    isLoading.value = true;

    try {
        await fetch('api/crypto/store', {
            method: 'POST',
        });

        if (myTable.value) {
            myTable.value.ajax.reload();
            isLoading.value = false;
        }
    } catch (error) {
        console.error('Failed to fetch data:', error);
        isLoading.value = false;
    }
};

onBeforeUnmount(() => {
    if (myTable.value) {
        myTable.value.destroy();
    }
});


defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<template>
    <Head title="Welcome">
    
    </Head>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Coin Marker Caps</a>
    <span v-if="isLoading"><h1 class="display-2"><b>Kraunama...</b></h1></span>
    <a class="btn btn-outline-success" type="submit" @click="fetchData">Gauti duomanis/ Atnaujinti</a>

    
  </div>
</nav>

    <div>
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <div class="container-fluid">
                   
                        <table id="myTable">
                        <thead>
                            <tr>
                                <th class="table-header">#</th>
                                <th class="table-header">Name(pavadinimas)</th>
                                <th class="table-header">Price(kaina)</th>
                                <th class="table-header">Market cap(rinkos riba)</th>
                                <th class="table-header">Volume 24h(pirkimo galia 24h)</th>
                                <th class="table-header">Volume change 24h(pirkimo galios pokytis 24h)</th>
                                <th class="table-header">Last updated(atnaujinta)</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                   
                </div>
            </div>
            <div class="mt-16">
            </div>

            <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
            </div>
        </div>
    </div>
</template>
<style>
</style>
