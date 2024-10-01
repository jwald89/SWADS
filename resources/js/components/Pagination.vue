<template>
    <div>
        <ul class="pagination">
            <li v-if="links.prev" @click="changePage(links.prev.url)">
                &laquo; Previous
            </li>
            <li
                v-for="link in links.links"
                :key="link.url"
                @click="changePage(link.url)"
                :class="{ active: link.active }"
            >
                {{ link.label }}
            </li>
            <li v-if="links.next" @click="changePage(links.next.url)">
                Next &raquo;
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        links: {
            type: Object,
            required: true,
        },
    },
    methods: {
        changePage(url) {
            const page = new URL(url).searchParams.get("page");
            this.$emit("page-changed", page);
        },
    },
};
</script>

<style>
.pagination {
    display: flex;
    list-style: none;
}
.pagination li {
    margin: 0 5px;
    cursor: pointer;
}
.pagination li.active {
    font-weight: bold;
}
</style>
