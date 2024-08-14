<template>
    <div class="grid-view-products-item">
        <ProductCard :product="product" />
    </div>
</template>

<script>
import ProductCard from "./../../ProductCard.vue";

export default {
    components: { ProductCard },

    props: ["product"],
};
</script>
