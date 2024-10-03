<template>
    <div class="defaultContainer">
        <div class="innerContainer" v-if="localCharacter.proficiencies.weapons.length > 0">
            <div>
                <div class="sanityController">
                    <div class="removeSanity" @click="removeFromProf('weapons')">-</div>
                    <div class="addSanity" @click="addFromProf('weapons'); updateCharacterData">+</div>
                </div>
                <span>Weapons</span>
                <ul>
                    <li v-for="(gain, index) in localCharacter.proficiencies.weapons">
                        <span class="input-sizer stacked" :data-value="localCharacter.proficiencies.weapons[index]">
                            <textarea v-model="localCharacter.proficiencies.weapons[index]"
                                oninput="this.parentNode.dataset.value = this.value" @input="updateCharacterData" rows="1"></textarea>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="innerContainer" v-if="localCharacter.proficiencies.armor.length > 0">
            <div>
                <div class="sanityController">
                    <div class="removeSanity" @click="removeFromProf('armor')">-</div>
                    <div class="addSanity" @click="addFromProf('armor'); updateCharacterData">+</div>
                </div>
                <span>Armor</span>
                <ul>
                    <li v-for="(gain, index) in localCharacter.proficiencies.armor">
                        <span class="input-sizer stacked" :data-value="localCharacter.proficiencies.armor[index]">
                            <textarea v-model="localCharacter.proficiencies.armor[index]"
                                oninput="this.parentNode.dataset.value = this.value" @input="updateCharacterData" rows="1"></textarea>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="innerContainer" v-if="localCharacter.proficiencies.tools.length > 0">
            <div>
                <div class="sanityController">
                    <div class="removeSanity" @click="removeFromProf('tools')">-</div>
                    <div class="addSanity" @click="addFromProf('tools'); updateCharacterData">+</div>
                </div>
                <span>Tools</span>
                <ul>
                    <li v-for="(gain, index) in localCharacter.proficiencies.tools">
                        <span class="input-sizer stacked" :data-value="localCharacter.proficiencies.tools[index]">
                            <textarea v-model="localCharacter.proficiencies.tools[index]"
                                oninput="this.parentNode.dataset.value = this.value" @input="updateCharacterData" rows="1"></textarea>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="innerContainer" v-if="localCharacter.proficiencies.languages.length > 0">
            <div>
                <div class="sanityController">
                    <div class="removeSanity" @click="removeFromProf('languages')">-</div>
                    <div class="addSanity" @click="addFromProf('languages'); updateCharacterData">+</div>
                </div>
                <span>Languages</span>
                <ul>
                    <li v-for="(gain, index) in localCharacter.proficiencies.languages">
                        <span class="input-sizer stacked" :data-value="localCharacter.proficiencies.languages[index]">
                            <textarea v-model="localCharacter.proficiencies.languages[index]"
                                oninput="this.parentNode.dataset.value = this.value" @input="updateCharacterData" rows="1"></textarea>
                        </span>
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

function removeFromProf(removingArray) {
    if (removingArray === 'weapons') {
        localCharacter.value.proficiencies.weapons.pop()
    } else if (removingArray === 'armor') {
        localCharacter.value.proficiencies.armor.pop()
    } else if (removingArray === 'tools') {
        localCharacter.value.proficiencies.tools.pop()
    } else if (removingArray === 'languages') {
        localCharacter.value.proficiencies.languages.pop()
    }

    emit('update:characterData')
}

function addFromProf(addArray) {
    if (addArray === 'weapons') {
        localCharacter.value.proficiencies.weapons.push('')
    } else if (addArray === 'armor') {
        localCharacter.value.proficiencies.armor.push('')
    } else if (addArray === 'tools') {
        localCharacter.value.proficiencies.tools.push('')
    } else if (addArray === 'languages') {
        localCharacter.value.proficiencies.languages.push('')
    }

    emit('update:characterData')
}
</script>

<style scoped lang="scss">
.defaultContainer {
    column-gap: 40px;
    row-gap: 20px;
    flex-direction: row;
    flex-wrap: wrap;

    >.innerContainer {
        width: calc(50% - 20px);

        >div {
            flex-direction: column;

            ul {
                list-style: initial;
                padding-left: 1.25em;

                span {
                    width: 100%;
                    color: var(--colorWhite);
                    font-weight: normal;
                }
            }

            .sanityController {
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

                    &.addSanity {
                        background-color: var(--colorAdvantage);

                        &:hover {
                            opacity: 1;
                        }
                    }

                    &.removeSanity {
                        background-color: var(--colorDisadvantage);

                        &:hover {
                            opacity: 1;
                        }
                    }
                }
            }
        }
    }
}
</style>
