<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    records: {
        required: true,
    },
    link: {
        required: true,
    },
    onPageChange: {
        required: true,
    },
});

const fetchRecords = (url) => {
    if (url) {
        const pageMatch = url.match(/page=(\d+)/);
        const page = pageMatch ? pageMatch[1] : 1;

        router.visit(url, {
            preserveScroll: true,
            preserveState: true,
        });
        props.onPageChange(page); // Call to update the table
    }
};

// Function to generate the page numbers to display
const getDisplayedPages = (currentPage, lastPage) => {
    const pages = [];
    const maxVisiblePages = 5; // Adjust this to change number of visible pages
    const halfVisible = Math.floor(maxVisiblePages / 2);

    let startPage = Math.max(1, currentPage - halfVisible);
    let endPage = Math.min(lastPage, currentPage + halfVisible);

    // Adjust start and end if near the edges
    if (currentPage <= halfVisible) {
        endPage = Math.min(maxVisiblePages, lastPage);
    }
    if (currentPage + halfVisible >= lastPage) {
        startPage = Math.max(lastPage - maxVisiblePages + 1, 1);
    }

    if (startPage > 1) {
        pages.push(1);
        if (startPage > 2) pages.push("..."); // Add ellipsis
    }

    for (let i = startPage; i <= endPage; i++) {
        pages.push(i);
    }

    if (endPage < lastPage) {
        if (endPage < lastPage - 1) pages.push("..."); // Add ellipsis
        pages.push(lastPage);
    }

    return pages;
};
</script>

<template>
    <div>
        <nav aria-label="Page navigation" v-if="records?.data?.length !== 0">
            <ul class="pagination justify-content-end me-2">
                <li
                    class="page-item"
                    :class="{ disabled: !records.prev_page_url }"
                >
                    <a
                        class="page-link"
                        href="#"
                        @click="fetchRecords(records.prev_page_url)"
                    >
                        Previous
                    </a>
                </li>
                <li
                    class="page-item"
                    v-for="(page, index) in getDisplayedPages(
                        records.current_page,
                        records.last_page
                    )"
                    :key="index"
                    :class="{ active: page === records.current_page }"
                >
                    <a
                        class="page-link"
                        href="#"
                        v-if="page !== '...'"
                        @click="fetchRecords(`${link}?page=${page}`)"
                    >
                        {{ page }}
                    </a>
                    <span v-else class="page-link disabled">...</span>
                </li>
                <li
                    class="page-item"
                    :class="{
                        disabled:
                            !records.next_page_url ||
                            records.current_page === records.last_page,
                    }"
                >
                    <a
                        class="page-link"
                        href="#"
                        @click="fetchRecords(records.next_page_url)"
                        :disabled="records.current_page === records.last_page"
                    >
                        Next
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>
