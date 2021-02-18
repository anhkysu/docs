<template>
    <div id="collection-list">
        <div class="row">
            <collection-item class="col-md-3" v-for="item in collectionList" :key="item.id" :collection="item"></collection-item>
        </div>
    </div>
</template>

<script src="../js/collectionlist.js"></script>