@props(['field'])

<template x-if="errors['{{ $field }}']">
    <ul class="text-sm text-red-600 space-y-1">
        <template x-for="msg in errors['{{ $field }}']">
            <li x-text="msg"></li>
        </template>
    </ul>
</template>