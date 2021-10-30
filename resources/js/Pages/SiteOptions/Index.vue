<template>
        <app-header></app-header>

        <div class="container">
            <div class="row">
                <div class="col-md-12" style="margin-top: 20px">
                    <h2 class="text-left">All Siteoptions</h2>

                    <errors-and-messages :errors="errors"></errors-and-messages>

                    <div class="nav-item">
                        <inertia-link :href="$route('siteoption.create')" class="nav-link">Create Siteoption</inertia-link>
                    </div>

                    <div v-if="siteoptions.data.length > 0">

                        <div>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Index</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Content</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(siteoption, index) in siteoptions.data" :key="index">
                                    <th scope="row">{{ index }}</th>
                                    <td>{{siteoption.title}}</td>
                                    <td>{{siteoption.content}}</td>
                                    <td>
                                        <inertia-link :href="$route('siteoption.edit', {id: siteoption.id})" class="btn btn-primary pull-right action-btn">Edit</inertia-link>
                                        <a href="javascript:void(0);" class="btn btn-warning pull-right action-btn" @click.prevent="deleteSiteoption(siteoption.id)"><i class="fas fa-trash-alt"></i> Delete </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination links-->
                        <nav aria-label="Page navigation" v-if="siteoptions.total > siteoptions.per_page" style="margin-top: 20px">
                            <ul class="pagination">
                                <!-- Previous link -->
                                <li :class="'page-item' + (siteoptions.links[0].url == null ? ' disabled' : '')">
                                    <inertia-link :href="siteoptions.links[0].url == null ? '#' : siteoptions.links[0].url" class="page-link" v-html="siteoptions.links[0].label"></inertia-link>
                                </li>

                                <!-- Numbers -->
                                <li v-for="item in numberLinks" :class="'page-item' + (item.active ? ' disabled' : '')">
                                    <inertia-link :href="item.active ? '#' : item.url" class="page-link" v-html="item.label"></inertia-link>
                                </li>

                                <!-- Next link -->
                                <li :class="'page-item' + (siteoptions.links[siteoptions.links.length - 1].url == null ? ' disabled' : '')">
                                    <inertia-link :href="siteoptions.links[siteoptions.links.length - 1].url == null ? '#' : siteoptions.links[siteoptions.links.length - 1].url" class="page-link" v-html="siteoptions.links[siteoptions.links.length - 1].label"></inertia-link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="text-center" v-else>
                        No siteoptions found! <inertia-link :href="$route('siteoption.create')">Create Siteoption</inertia-link>
                    </div>
                </div>
            </div>
        </div>

</template>

<script>
import AppHeader from "../../Partials/AppHeader";
import ErrorsAndMessages from "../../Partials/ErrorsAndMessages";
import {usePage} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import {computed, inject} from "vue";

export default {
    name: "SiteOptions",
    components: {
        ErrorsAndMessages,
        AppHeader
    },
    props: {
        errors: Object
    },
    setup() {
        const route = inject('$route');

        const deleteSiteoption = (id) => {
            if (!confirm('Are you sure?')) return;
            Inertia.delete(route('siteoption.destroy', {id}));
        }

        const siteoptions = computed(() => usePage().props.value.siteoptions);

        const numberLinks = siteoptions.value.links.filter((v, i) => i > 0 && i < siteoptions.value.links.length - 1);

        return {
            siteoptions,
            deleteSiteoption,
            numberLinks
        }
    }
}
</script>

<style scoped>
    .action-btn {
        margin-left: 12px;
        font-size: 13px;
    }

    .article {
        margin-top: 20px;
    }

</style>
