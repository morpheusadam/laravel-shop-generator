<draggable
    animation="150"
    class="product-form-column"
    :class="{ dragging: isRightColumnSectionDragging }"
    data-name="product-form-right-sections"
    force-fallback="true"
    handle=".drag-handle"
    :list="formRightSections"
    :store="storeFormSections"
    @choose="isRightColumnSectionDragging = true"
    @unchoose="isRightColumnSectionDragging = false"
    @change="notifySectionOrderChange"
>
    <div class="box" v-for="(section, index) in formRightSections" :data-id="section" :key="index">
        @include('product::admin.products.layouts.sections.pricing')
        @include('product::admin.products.layouts.sections.inventory')
        @include('product::admin.products.layouts.sections.media')
        @include('product::admin.products.layouts.sections.linked_products')
        @include('product::admin.products.layouts.sections.seo')
        @include('product::admin.products.layouts.sections.additional')
    </div>
</draggable>
