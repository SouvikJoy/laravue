<template>
    <app-header />
    <div class="container">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <inertia-link :href="$route('product.index')" class="nav-link">Products</inertia-link>
            </li>
            <li class="nav-item active">
                <inertia-link :href="$route('post.index')" class="nav-link">Posts</inertia-link>
            </li>
            <li class="nav-item active">
                <inertia-link :href="$route('category.index')" class="nav-link">Categories</inertia-link>
            </li>
            <li class="nav-item active">
                <inertia-link :href="$route('siteoption.index')" class="nav-link">Site Options</inertia-link>
            </li>
        </ul>
    </div>
</template>

<script>
import AppHeader from "../Partials/AppHeader";
export default {
    name: "Dashboard",
    components: {AppHeader}
}
</script>

<style scoped>

</style>
