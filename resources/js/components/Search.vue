<script setup>
import axios from "axios";
import { ref } from "vue";

const search = ref();

const emit = defineEmits(["results"]);

const filterData = async () => {
    try {
        const response = await axios.get("/api/intake", {
            params: {
                search: search.value,
            },
        });

        emit("results", response.data);
    } catch (error) {
        console.error("Error fetching datas:", error);
    }
};
</script>

<template>
    <div class="form-group">
        <div class="d-flex col-lg-12">
            <div class="col-lg-6">
                <input
                    v-model="search"
                    type="text"
                    class="form-control"
                    @keypress.enter="filterData"
                    placeholder="Search here.."
                />
            </div>
            <div class="col-lg-6">
                <button @click="filterData" class="btn btn-success">
                    Search
                </button>
            </div>
        </div>
    </div>
</template>
