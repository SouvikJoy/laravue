<template>
        <app-header></app-header>

        <div class="container">
            <div class="row">
                <div class="col-md-12" style="margin-top: 20px">
                    <h2 class="text-left">All Categories</h2>

                    <errors-and-messages :errors="errors"></errors-and-messages>

                    <div class="nav-item">
                        <inertia-link :href="$route('category.create')" class="nav-link">Create Category</inertia-link>
                    </div>

                    <div v-if="categories.data.length > 0">

                        <div>


                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Index</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Image</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(category, index) in categories.data" :key="index">
                                    <th scope="row">{{ index }}</th>
                                    <td>{{category.title}}</td>
                                    <td>{{category.content}}</td>
                                    <td><img v-if="category.image_url" width="100" height="80" :src="category.image_url" class="pull-left img-responsive thumb margin10 img-thumbnail"></td>
                                    <td>
                                        <inertia-link :href="$route('category.edit', {id: category.id})" class="btn btn-primary pull-right action-btn">Edit Category</inertia-link>
                                        <a href="javascript:void(0);" class="btn btn-warning pull-right action-btn" @click.prevent="deleteCategory(category.id)"><i class="fas fa-trash-alt"></i> Delete Category</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>


                            <!--                        <h4>{{category.title}}</h4>
                                                    <img v-if="category.image_url" width="300" height="250" :src="category.image_url" class="pull-left img-responsive thumb margin10 img-thumbnail">
                                                    <article>
                                                        <p>
                                                            {{ category.content }}
                                                        </p>
                                                    </article>
                                                    <inertia-link :href="$route('category.edit', {id: category.id})" class="btn btn-primary pull-right action-btn">Edit Post</inertia-link>
                                                    <a href="javascript:void(0);" class="btn btn-warning pull-right action-btn" @click.prevent="deletePost(category.id)"><i class="fas fa-trash-alt"></i> Delete Post</a>-->
                        </div>

                        <!-- Pagination links-->
                        <nav aria-label="Page navigation" v-if="categories.total > categories.per_page" style="margin-top: 20px">
                            <ul class="pagination">
                                <!-- Previous link -->
                                <li :class="'page-item' + (categories.links[0].url == null ? ' disabled' : '')">
                                    <inertia-link :href="categories.links[0].url == null ? '#' : categories.links[0].url" class="page-link" v-html="categories.links[0].label"></inertia-link>
                                </li>

                                <!-- Numbers -->
                                <li v-for="item in numberLinks" :class="'page-item' + (item.active ? ' disabled' : '')">
                                    <inertia-link :href="item.active ? '#' : item.url" class="page-link" v-html="item.label"></inertia-link>
                                </li>

                                <!-- Next link -->
                                <li :class="'page-item' + (categories.links[categories.links.length - 1].url == null ? ' disabled' : '')">
                                    <inertia-link :href="categories.links[categories.links.length - 1].url == null ? '#' : categories.links[categories.links.length - 1].url" class="page-link" v-html="categories.links[categories.links.length - 1].label"></inertia-link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="text-center" v-else>
                        No categories found! <inertia-link :href="$route('category.create')">Create Category</inertia-link>
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
    name: "Categories",
    components: {
        ErrorsAndMessages,
        AppHeader
    },
    props: {
        errors: Object
    },
    setup() {
        const route = inject('$route');

        const deleteCategory = (id) => {
            if (!confirm('Are you sure?')) return;
            Inertia.delete(route('category.destroy', {id}));
        }

        const categories = computed(() => usePage().props.value.categories);

        const numberLinks = categories.value.links.filter((v, i) => i > 0 && i < categories.value.links.length - 1);

        return {
            categories,
            deleteCategory,
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
