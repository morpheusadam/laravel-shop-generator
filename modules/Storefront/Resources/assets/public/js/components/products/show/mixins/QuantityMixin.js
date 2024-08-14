export default {
    computed: {
        maxQuantity() {
            return this.item.is_in_stock && this.item.does_manage_stock
                ? this.item.qty
                : null;
        },

        isQtyIncreaseDisabled() {
            return (
                this.item.is_out_of_stock ||
                (this.maxQuantity !== null &&
                    this.cartItemForm.qty >= this.item.qty) ||
                !this.isActiveItem
            );
        },

        isQtyDecreaseDisabled() {
            return (
                this.item.is_out_of_stock ||
                this.cartItemForm.qty <= 1 ||
                !this.isActiveItem
            );
        },
    },

    methods: {
        updateQuantity(event, qty) {
            if (isNaN(qty) || qty < 1) {
                this.cartItemForm.qty = 1;

                return;
            }

            this.cartItemForm.qty = qty;

            $(event.currentTarget)
                .parents(".btn-wrapper")
                .siblings(".input-quantity")
                .trigger("focus");

            if (this.exceedsMaxStock(qty)) {
                this.cartItemForm.qty = this.item.qty;

                return;
            }
        },

        exceedsMaxStock(qty) {
            return this.item.does_manage_stock && this.item.qty < qty;
        },

        reduceToMaxQuantity() {
            if (
                this.item.does_manage_stock &&
                this.cartItemForm.qty > this.item.qty
            ) {
                this.cartItemForm.qty = this.item.qty;
            }
        },
    },
};
