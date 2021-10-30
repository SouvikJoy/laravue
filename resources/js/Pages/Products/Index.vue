<template>
        <app-header></app-header>

        <div class="container">
            <div class="row">
                <div class="col-md-12" style="margin-top: 20px">
                    <h2 class="text-left">All Products</h2>

                    <errors-and-messages :errors="errors"></errors-and-messages>

                    <div class="nav-item">
                        <inertia-link :href="$route('product.create')" class="nav-link">Create Product</inertia-link>
                    </div>

                    <div v-if="products.data.length > 0">

                        <div class="col-md-10 article" v-for="product in products.data" :key="product.id">
                            <h4>{{product.title}}</h4>
                            <img v-if="product.image_url" width="300" height="250" :src="product.image_url" class="pull-left img-responsive thumb margin10 img-thumbnail">
                            <article>
                                <p>
                                    {{ product.image_url }}
                                </p>
                                <p>
                                    {{ product.slug }}
                                </p>
                                <p>
                                    {{ product.brief }}
                                </p>
                                <p>
                                    {{ product.description }}
                                </p>
                                <p>
                                    {{ product.price }}
                                </p>
                            </article>
                            <inertia-link :href="$route('product.edit', {id: product.id})" class="btn btn-primary pull-right action-btn">Edit Product</inertia-link>
                            <a href="javascript:void(0);" class="btn btn-warning pull-right action-btn" @click.prevent="deleteProduct(product.id)"><i class="fas fa-trash-alt"></i> Delete Product</a>
                        </div>

                        <!-- Pagination links-->
                        <nav aria-label="Page navigation" v-if="products.total > products.per_page" style="margin-top: 20px">
                            <ul class="pagination">
                                <!-- Previous link -->
                                <li :class="'page-item' + (products.links[0].url == null ? ' disabled' : '')">
                                    <inertia-link :href="products.links[0].url == null ? '#' : products.links[0].url" class="page-link" v-html="products.links[0].label"></inertia-link>
                                </li>

                                <!-- Numbers -->
                                <li v-for="item in numberLinks" :class="'page-item' + (item.active ? ' disabled' : '')">
                                    <inertia-link :href="item.active ? '#' : item.url" class="page-link" v-html="item.label"></inertia-link>
                                </li>

                                <!-- Next link -->
                                <li :class="'page-item' + (products.links[products.links.length - 1].url == null ? ' disabled' : '')">
                                    <inertia-link :href="products.links[products.links.length - 1].url == null ? '#' : products.links[products.links.length - 1].url" class="page-link" v-html="products.links[products.links.length - 1].label"></inertia-link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="text-center" v-else>
                        No products found! <inertia-link :href="$route('product.create')">Create Product</inertia-link>
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
    name: "Products",
    components: {
        ErrorsAndMessages,
        AppHeader
    },
    props: {
        errors: Object
    },
    setup() {
        const route = inject('$route');

        const deleteProduct = (id) => {
            if (!confirm('Are you sure?')) return;
            Inertia.delete(route('product.destroy', {id}));
        }

        const products = computed(() => usePage().props.value.products);

        const numberLinks = products.value.links.filter((v, i) => i > 0 && i < products.value.links.length - 1);

        return {
            products,
            deleteProduct,
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
