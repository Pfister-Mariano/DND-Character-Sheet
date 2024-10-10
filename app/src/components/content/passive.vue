<template>
    <div class="defaultContainer">
        <div class="innerContainer">
            <div>
                <div class="passiveController">
                    <div class="removePassive" @click="removeFromPassive('otherPassives')">-</div>
                    <div class="addPassive" @click="addFromPassive('otherPassives'); updateCharacterData">+</div>
                </div>
                <span>Passive:</span>
                <ul>
                    <li v-for="(passive, index) in localCharacter.otherPassives">
                        <input class="alignRight" type="text" v-model="localCharacter.otherPassives[index]"
                            @input="updateCharacterData">
                    </li>
                </ul>
            </div>
        </div>
        <div class="innerContainer">
            <div>
                <div class="passiveController">
                    <div class="removePassive" @click="removeFromPassive('resistances')">-</div>
                    <div class="addPassive" @click="addFromPassive('resistances'); updateCharacterData">+</div>
                </div>
                <span>Resistances:</span>
                <ul>
                    <li v-for="(resist, index) in localCharacter.resistances">
                        <input class="alignRight" type="text" v-model="localCharacter.resistances[index]"
                            @input="updateCharacterData">
                    </li>
                </ul>
            </div>
        </div>
        <div class="innerContainer">
            <div>
                <div class="passiveController">
                    <div class="removePassive" @click="removeFromPassive('immunities')">-</div>
                    <div class="addPassive" @click="addFromPassive('immunities'); updateCharacterData">+</div>
                </div>
                <span>Immunities:</span>
                <ul>
                    <li v-for="(immunity, index) in localCharacter.immunities">
                        <input class="alignRight" type="text" v-model="localCharacter.immunities[index]"
                            @input="updateCharacterData">
                    </li>
                </ul>
            </div>
        </div>
        <div class="innerContainer">
            <div>
                <div class="passiveController">
                    <div class="removePassive" @click="removeFromPassive('vulnerability')">-</div>
                    <div class="addPassive" @click="addFromPassive('vulnerability'); updateCharacterData">+</div>
                </div>
                <span>Vulnerabilities:</span>
                <ul>
                    <li v-for="(vulnerability, index) in localCharacter.vulnerability">
                        <input class="alignRight" type="text" v-model="localCharacter.vulnerability[index]"
                            @input="updateCharacterData">
                    </li>
                </ul>
            </div>
        </div>
        <div class="innerContainer">
            <div>
                <div class="passiveController">
                    <div class="removePassive" @click="removeFromPassive('conditionImmunities')">-</div>
                    <div class="addPassive" @click="addFromPassive('conditionImmunities'); updateCharacterData">+</div>
                </div>
                <span>Cond. Immunities:</span>
                <ul>
                    <li v-for="(condImmunity, index) in localCharacter.conditionImmunities">
                        <input class="alignRight" type="text" v-model="localCharacter.conditionImmunities[index]"
                            @input="updateCharacterData">
                    </li>
                </ul>
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
function removeFromPassive(removingArray) {
    if (removingArray === 'resistances') {
        localCharacter.value.resistances.pop()
    } else if (removingArray === 'immunities') {
        localCharacter.value.immunities.pop()
    } else if (removingArray === 'vulnerability') {
        localCharacter.value.vulnerability.pop()
    } else if (removingArray === 'conditionImmunities') {
        localCharacter.value.conditionImmunities.pop()
    } else if (removingArray === 'otherPassives') {
        localCharacter.value.otherPassives.pop()
    }
    
    emit('update:characterData')
}
function addFromPassive(addArray) {
    if (addArray === 'resistances') {
        localCharacter.value.resistances.push('')
    } else if (addArray === 'immunities') {
        localCharacter.value.immunities.push('')
    } else if (addArray === 'vulnerability') {
        localCharacter.value.vulnerability.push('')
    } else if (addArray === 'conditionImmunities') {
        localCharacter.value.conditionImmunities.push('')
    } else if (addArray === 'otherPassives') {
        localCharacter.value.otherPassives.push('')
    }
    
    emit('update:characterData')
}
</script>

<style scoped lang="scss">
.defaultContainer>.innerContainer>div {
    flex-direction: column;

    ul {
        list-style: initial;
        padding-left: 1.25em;

        input {
            width: 100%;
        }
    }

    .passiveController {
        height: 100%;
        width: calc(100% + 56px);
        position: absolute;
        left: -28px;
        z-index: 10;
        border-radius: 3px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        pointer-events: none;

        >div {
            height: 16px;
            width: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border-radius: 100%;
            pointer-events: initial;
            opacity: 0;
            transition: var(--transition);

            &.addPassive {
                background-color: var(--colorAdvantage);

                &:hover {
                    opacity: 1;
                }
            }

            &.removePassive {
                background-color: var(--colorDisadvantage);

                &:hover {
                    opacity: 1;
                }
            }
        }
    }
}
</style>
