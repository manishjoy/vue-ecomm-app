<template>
    <div class="item">
        <div class="sidebar-item">
            <div class="itemside align-items-center">
                <div class="item-info">
                    <span>{{itemData.name}}</span>
                    <br><span>Qty: {{itemData.qty}}</span>
                    <br><strong>Total Price: {{itemData.price}}</strong>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CheckoutItems',
    props: {
        itemData: {
            default: {}
        },
        currencySymbol: {
            default: '$'
        }
    }
}
</script>