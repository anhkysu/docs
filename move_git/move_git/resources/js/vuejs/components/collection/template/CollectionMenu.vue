<template>
    <ul class="nav flex-column">
        <li class=nav-item>
            <router-link :to="{ name: 'collection-list' }">My List</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{ name: 'collection-add' }">Add </router-link>
        </li>
    </ul>
</template>