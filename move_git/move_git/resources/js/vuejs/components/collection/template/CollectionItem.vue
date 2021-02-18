<template>
    <div class="collection-item">
        <div class="card text-white mb-3" :class="collection.backgroundStyle">
          <div class="card-header"><h5>{{collection.value}}</h5></div>
          <div class="card-body">
            <ul class="card-text">
                <ul>
                    <li v-for="explanation in collection.explanations" :key="explanation.id">
                        {{explanation.meanings}}
                    </li>
                </ul>
            </ul>
          </div>
        </div>
</div>
</template>

<script src="../js/collectionitem.js"></script>