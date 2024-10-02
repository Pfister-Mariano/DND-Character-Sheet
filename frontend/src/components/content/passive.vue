<template>
    <div class="defaultContainer">
        <div class="innerContainer">
            <div>
                <span>Spellcasting:</span>
                <input style="width: 100%;" class="alignRight" type="text" v-model="localCharacter.spellcasting.castingSkill" @input="updateCharacterData">
            </div>
        </div>
        <div class="innerContainer manaContainer">
            <div>
                <span>Mana:</span>
                <div>
                    <input style="width: 3ch;" type="number" maxlength="3" v-model="localCharacter.spellcasting.currentMana" @input="updateCharacterData"> / <input style="width: 3ch;" type="number" maxlength="3" v-model="localCharacter.spellcasting.maxMana" @input="updateCharacterData">
                </div>
            </div>
        </div>
        <div class="innerContainer">
            <div>
                <span>Spell ATK Bonus:</span>
                <div>
                    +<input type="number" maxlength="2" v-model="localCharacter.spellcasting.spellAtkBonus" @input="updateCharacterData">
                </div>
            </div>
        </div>
        <div class="innerContainer">
            <div>
                <span>Spell Save DC:</span>
                <input type="number" maxlength="2" v-model="localCharacter.spellcasting.spellSaveDC" @input="updateCharacterData">
            </div>
        </div>
    </div>
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

<style scoped lang="scss">
    
</style>
