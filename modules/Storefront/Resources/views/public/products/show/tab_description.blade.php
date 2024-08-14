<div id="description" class="tab-pane description" :class="{ active: activeTab === 'description' }">
    <div ref="descriptionContent" class="content" :class="{ active: showDescriptionContent, 'less-content': !isShowMore }">
        {!! $product->description !!}
    </div>

    <button type="button" class="btn btn-default btn-view-more" :class="{ 'btn-show': isShowMore }"
        @click="toggleDescriptionContent"
        v-text="showDescriptionContent ? '{{ trans('storefront::product.show_less') }}' : '{{ trans('storefront::product.show_more') }}'">
    </button>
</div>
