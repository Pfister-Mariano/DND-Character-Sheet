<template>
    <section>
        SPELLCASTING 
    </section>
</template>

<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';

const props = defineProps({
    characterData: {
        type: Object,
        required: true
    }
});

const localCharacter = ref(props.characterData);

watch(localCharacter, (newVal) => {
    localCharacter.value = newVal;
    props.characterData = newVal
});

const emit = defineEmits(['update:characterData']);

function updateCharacterData(event) {
    const newSize = Number(event.target.value);
    emit('update:characterData', newSize);
}

</script>

<style scoped lang="scss"></style>
