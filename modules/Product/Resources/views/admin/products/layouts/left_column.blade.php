@include('product::admin.products.layouts.sections.general')

<draggable
    animation="150"
    class="product-form-column"
    :class="{ dragging: isLeftColumnSectionDragging }"
    data-name="product-form-left-sections"
    force-fallback="true"
    handle=".drag-handle"
    :list="formLeftSections"
    :store="storeFormSections"
    @choose="isLeftColumnSectionDragging = true"
    @unchoose="isLeftColumnSectionDragging = false"
    @change="notifySectionOrderChange"
>
    <div class="box" v-for="(section, sectionIndex) in formLeftSections" :data-id="section" :key="sectionIndex">
        @include('product::admin.products.layouts.sections.attributes')
        @include('product::admin.products.layouts.sections.downloads')
        @include('product::admin.products.layouts.sections.variations')
        @include('product::admin.products.layouts.sections.variants')
        @include('product::admin.products.layouts.sections.options')
    </div>
</draggable>
