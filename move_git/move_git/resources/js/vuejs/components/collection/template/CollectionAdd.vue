<template>
    <div id="collection-add">
        <div method="POST" class="form">
            <div class="form-row">
                <div class="form-group col-md-5">
                    <input type="value" class="form-control" placeholder="Enter your collection ..." v-model="collection.value">
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control" v-model="collection.pos">
                        <option v-for="item in posList" :value="item.id"  >
                             {{ item.label }}
                        </option>

                    </select>
                </div>
                <div class="form-group col-md-3">
                    <button class="btn btn-warning float-right" v-on:click="resetCollection()">Reset</button>&nbsp;
                    <button class="btn btn-success float-right" v-on:click="saveCollection()">Save</button>
                </div>
            </div>
            <section id="explanation">
                <explanation-item v-for="explanation in collection.explanations" :key="explanation.id" :explanation="explanation" @add="addExplanation" @remove="removeExplanation"></explanation-item>
            </section>
        </div>
    </div>
</template>

<script src="../js/collectionadd.js"></script>