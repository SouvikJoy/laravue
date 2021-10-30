<template>
        <app-header></app-header>

        <div class="container">
            <div class="row">
                <div class="col-md-12" style="margin-top: 20px">
                    <h2 class="text-left">All Services</h2>

                    <errors-and-messages :errors="errors"></errors-and-messages>

                    <div class="nav-item">
                        <inertia-link :href="$route('service.create')" class="nav-link">Create Service</inertia-link>
                    </div>

                    <div v-if="services.data.length > 0">

                        <div>


                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Index</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(service, index) in services.data" :key="index">
                                    <th scope="row">{{ index }}</th>
                                    <td>{{service.title}}</td>
                                    <td>{{service.description}}</td>
                                    <td><img v-if="service.image" width="100" height="80" :src="service.image" class="pull-left img-responsive thumb margin10 img-thumbnail"></td>
                                    <td>
                                        <inertia-link :href="$route('service.edit', {id: service.id})" class="btn btn-primary pull-right action-btn">Edit Service</inertia-link>
                                        <a href="javascript:void(0);" class="btn btn-warning pull-right action-btn" @click.prevent="deleteService(service.id)"><i class="fas fa-trash-alt"></i> Delete Service</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination links-->
                        <nav aria-label="Page navigation" v-if="services.total > services.per_page" style="margin-top: 20px">
                            <ul class="pagination">
                                <!-- Previous link -->
                                <li :class="'page-item' + (services.links[0].url == null ? ' disabled' : '')">
                                    <inertia-link :href="services.links[0].url == null ? '#' : services.links[0].url" class="page-link" v-html="services.links[0].label"></inertia-link>
                                </li>

                                <!-- Numbers -->
                                <li v-for="item in numberLinks" :class="'page-item' + (item.active ? ' disabled' : '')">
                                    <inertia-link :href="item.active ? '#' : item.url" class="page-link" v-html="item.label"></inertia-link>
                                </li>

                                <!-- Next link -->
                                <li :class="'page-item' + (services.links[services.links.length - 1].url == null ? ' disabled' : '')">
                                    <inertia-link :href="services.links[services.links.length - 1].url == null ? '#' : services.links[services.links.length - 1].url" class="page-link" v-html="services.links[services.links.length - 1].label"></inertia-link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="text-center" v-else>
                        No services found! <inertia-link :href="$route('service.create')">Create Service</inertia-link>
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
    name: "Services",
    components: {
        ErrorsAndMessages,
        AppHeader
    },
    props: {
        errors: Object
    },
    setup() {
        const route = inject('$route');

        const deleteService = (id) => {
            if (!confirm('Are you sure?')) return;
            Inertia.delete(route('service.destroy', {id}));
        }

        const services = computed(() => usePage().props.value.services);

        const numberLinks = services.value.links.filter((v, i) => i > 0 && i < services.value.links.length - 1);

        return {
            services,
            deleteService,
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
