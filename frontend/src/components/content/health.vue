<template>
    <div class="healthWrapper">
        <div class="healthContainer">
            <div>
                <span>HP:</span> <input class="alignRight" type="text" v-model="localCharacter.health.currentHP" @input="updateCharacterData"> / <input type="text" v-model="localCharacter.health.maxHP" @input="updateCharacterData">
            </div>
            <div>
                <span>Temp:</span> <input type="text" v-model="localCharacter.health.tempHP">
            </div>
            <div>
                <span>Hit-Dice:</span> <input class="alignRight" type="text" maxlength="2" v-model="localCharacter.health.hitDiceAmount" @input="updateCharacterData">D<input type="text" maxlength="2" v-model="localCharacter.health.hitDice" @input="updateCharacterData">
            </div>
        </div>
        <div class="acContainer">
            <div>
                <span>AC:</span> <input type="text" maxlength="2" v-model="localCharacter.ac" @input="updateCharacterData">
            </div>
            <div>
                <span>Initiative:</span> <input type="text" maxlength="2" v-model="localCharacter.initiative" @input="updateCharacterData">
            </div>
        </div>
        <div class="sanityContainer">
            <div>
                <span>Sanity:</span> <input type="text" maxlength="2" v-model="localCharacter.sanity" @input="updateCharacterData">
            </div>
            <div>
                <span>Exhaustion:</span> <input type="text" maxlength="2" v-model="localCharacter.exhaustion" @input="updateCharacterData">
            </div>
        </div>
        <div class="speedContainer">
            <div>
                <span>Walking:</span> <input class="alignRight" type="text" v-model="localCharacter.speed.walking" @input="updateCharacterData"> Feet
            </div>
            <div>
                <span>Climbing:</span> <input class="alignRight" type="text" v-model="localCharacter.speed.climbing" @input="updateCharacterData"> Feet
            </div>
            <div>
                <span>Swimming:</span> <input class="alignRight" type="text" v-model="localCharacter.speed.swimming" @input="updateCharacterData"> Feet
            </div>
            <div>
                <span>Fly:</span> <input class="alignRight" type="text" v-model="localCharacter.speed.fly" @input="updateCharacterData"> Feet
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

function updateCharacterData() {
    emit('update:characterData');
}

</script>

<style scoped lang="scss">
    .healthWrapper{
        display: flex;
        flex-direction: column;
        gap: 10px;
        > div{
            background-color: var(--colorBG3);
            border-radius: 3px;
            padding: 5px 10px;
            display: flex;
            flex-direction: column;
            gap: 3px;
            span{
                display: block;
                font-weight: 600;
                color: var(--colorBlueLight);
                padding-right: .75ch;
                flex-shrink: 0;
            }
            input{
                font-weight: 400;
                width: 2ch;
                padding-right: .5ch;
            }
            >div{
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
            }
        }
        input.alignRight {
            text-align: right;
        }
        .speedContainer input{
            width: 3ch;
        }
        .healthContainer > div:nth-child(1) input:nth-child(3){
            padding-left: .5ch;
            padding-right: 0;
        }
        .healthContainer > div:nth-child(3) input:nth-child(2){
            padding-right: 0;
        }
    }
</style>
