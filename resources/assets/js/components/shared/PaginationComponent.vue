<template>
    <ul class="pagination" role="navigation">
        <li class="page-item">
            <a class="page-link" @click.prevent="changePage(pagination.first_page)"
               :disabled="pagination.current_page <= 1" rel="prev">First Page</a>
        </li>
        <li class="page-item">
            <a class="page-link" @click.prevent="changePage(pagination.current_page - 1)"
               :disabled="pagination.current_page <= 1" rel="prev" aria-label="Previous">&lsaquo;</a>
        </li>


        <li class="page-item" v-for="page in pages" :class="isCurrentPage(page) ? 'active' : ''">
            <a class="page-link" @click.prevent="changePage(page)" :disabled="pagination.current_page==page">{{ page}}</a>
        </li>
        <!--TODO PREVENT DISABLED LINKS CLICK-->
        <li class="page-item">
            <a class="page-link" @click.prevent="changePage(pagination.current_page + 1)"
               :disabled="pagination.current_page >= pagination.last_page" rel="prev" aria-label="Next">&rsaquo;</a>
        </li>
        <li class="page-item">
            <a class="page-link" @click.prevent="changePage(pagination.last_page)"
               :disabled="pagination.current_page >= pagination.last_page" rel="prev">Last Page</a>
        </li>
    </ul>
</template>

<style>
    .pagination {
        margin-top: 40px;
    }
</style>

<script>
    export default {
        props: ['pagination', 'offset'],
        methods: {
            isCurrentPage(page) {
                return this.pagination.current_page === page;
            },
            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }
                this.pagination.current_page = page;
                this.$emit('paginate');
            }
        },
        computed: {
            pages() {
                let pages = [];
                let from = this.pagination.current_page - Math.floor(this.offset / 2);
                if (from < 1) {
                    from = 1;
                }
                let to = from + this.offset - 1;
                if (to > this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                while (from <= to) {
                    pages.push(from);
                    from++;
                }
                return pages;
            }
        }
    }
</script>