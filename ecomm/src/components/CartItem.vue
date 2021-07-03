<template>
    <tr>
        <td>
            <figure class="itemside align-items-center">
                <div class="aside"><img :src="itemData.image" class="img-sm"></div>
                <figcaption class="info"> <router-link :to="{name: 'product', params: {id: itemData.id}}" class="title text-dark">{{itemData.name}}</router-link>
                </figcaption>
            </figure>
        </td>
        <td>
            <span>{{itemData.qty}}</span>
        </td>
        <td>
            <div class="price-wrap"> <var class="price">{{currencySymbol}} {{itemData.price}}</var></div>
        </td>
    </tr>
</template>
<script>
export default {
    name: 'CartItem',
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