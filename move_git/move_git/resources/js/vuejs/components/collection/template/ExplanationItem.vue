<template>
    <div class="form-row">
        <div class="form-group col-md-5">
            <input type="text" class="form-control" placeholder="Please input a meaning" v-model="explanation.meanings"/>
        </div>
        <div class="form-group col-md-6">
            <textarea type="text" class="form-control" placeholder="Please give an example" v-model="explanation.example"></textarea>
        </div>
        <div class="col-md-1">
            <div class="form-group" v-if="explanation.id == 0">
                 <button class="btn btn-primary" v-on:click="$emit('add')">
                     <img src="/bootstrap-icons/icons/plus.svg" alt="" width="32" height="32" title="addition">
                 </button>
            </div>
            <div class="form-group" v-else>
                 <button class="btn btn-danger" v-on:click="$emit('remove', explanation.id)">
                     <img src="/bootstrap-icons/icons/trash.svg" alt="" width="32" height="32" title="addition">
                 </button>
            </div>
        </div>
    </div>
</template>

<script src="../js/explanationitem.js"></script>