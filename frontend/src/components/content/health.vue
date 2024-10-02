<template>
    <div class="defaultContainer">
        <div class="innerContainer healthContainer">
            <div>
                <span>HP:</span> <input class="alignRight" type="text" v-model="localCharacter.health.currentHP" @input="updateCharacterData"> / <input type="text" v-model="localCharacter.health.maxHP" @input="updateCharacterData">
            </div>
            <div>
                <span>Temp:</span> <input class="alignRight" type="text" v-model="localCharacter.health.tempHP">
            </div>
            <div>
                <span>Hit-Dice:</span> <input class="alignRight" type="text" maxlength="2" v-model="localCharacter.health.hitDiceAmount" @input="updateCharacterData">D<input type="text" maxlength="2" v-model="localCharacter.health.hitDice" @input="updateCharacterData">
            </div>
        </div>
        <div class="innerContainer acContainer">
            <div>
                <span>AC:</span> <input type="text" maxlength="2" v-model="localCharacter.ac" @input="updateCharacterData">
            </div>
            <div>
                <span>Initiative:</span> <input type="text" maxlength="2" v-model="localCharacter.initiative" @input="updateCharacterData">
            </div>
        </div>
        <div class="innerContainer sanityContainer">
            <div>
                <span>Sanity:</span> <input type="text" maxlength="2" v-model="localCharacter.sanity" @input="updateCharacterData">
            </div>
            <div>
                <span>Exhaustion:</span> <input type="text" maxlength="2" v-model="localCharacter.exhaustion" @input="updateCharacterData">
            </div>
        </div>
        <div class="innerContainer speedContainer">
            <div>
                <span>Walking:</span>
                <div>
                    <input class="alignRight" type="text" v-model="localCharacter.speed.walking" @input="updateCharacterData"> Feet
                </div>
            </div>
            <div>
                <span>Climbing:</span>
                <div>
                    <input class="alignRight" type="text" v-model="localCharacter.speed.climbing" @input="updateCharacterData"> Feet
                </div>
            </div>
            <div>
                <span>Swimming:</span> 
                <input class="alignRight" type="text" v-model="localCharacter.speed.swimming" @input="updateCharacterData"> Feet
            </div>
            <div>
                <span>Fly:</span> 
                <div>
                    <input class="alignRight" type="text" v-model="localCharacter.speed.fly" @input="updateCharacterData"> Feet
                </div>
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
    .defaultContainer{
        > .innerContainer input{
            width: 3ch;
        }
        input.alignRight {
            text-align: right;
        }
        .sanityContainer,
        .acContainer{
            > div{
                >span{
                    width: 85px;
                }
            }
        }
        .speedContainer {
            > div{
                justify-content: space-between;
            }
            input{
                width: 3ch;
            }
        }
        .healthContainer{
            > div > span{
                width: 70px;
            }
            > div > input{
                padding: 0;
            }
            > div:nth-child(1){
                
                > input:nth-child(2){
                    padding-right: .5ch;
                }
                > input:nth-child(3){
                    padding-left: .5ch;
                    padding-right: 0;
                }
            }
        }
    }
</style>
