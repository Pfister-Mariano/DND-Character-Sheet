<template>
    <div class="defaultContainer">
        <div class="innerContainer sanityGain" v-if="localCharacter.sanityGain.length > 0">
            <div>
                <div class="sanityController">
                    <div class="removeSanity" @click="removeFromSanity('sanityGain')">-</div>
                    <div class="addSanity" @click="addFromSanity('sanityGain'); updateCharacterData">+</div>
                </div>
                <span>Sanity gain</span>
                <ul>
                    <li v-for="(gain, index) in localCharacter.sanityGain">
                        <span class="input-sizer stacked" :data-value="localCharacter.sanityGain[index]">
                            <textarea v-model="localCharacter.sanityGain[index]" oninput="this.parentNode.dataset.value = this.value" @input="updateCharacterData" rows="1"></textarea>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="innerContainer sanityLoss" v-if="localCharacter.sanityLoss.length > 0">
            <div>
                <div class="sanityController">
                    <div class="removeSanity" @click="removeFromSanity('sanityLoss')">-</div>
                    <div class="addSanity" @click="addFromSanity('sanityLoss'); updateCharacterData">+</div>
                </div>
                <span>Sanity loss</span>
                <ul>
                    <li v-for="(loss, index) in localCharacter.sanityLoss">
                        <span class="input-sizer stacked" :data-value="localCharacter.sanityLoss[index]">
                            <textarea v-model="localCharacter.sanityLoss[index]" oninput="this.parentNode.dataset.value = this.value" @input="updateCharacterData" rows="1"></textarea>
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

function removeFromSanity(removingArray) {
    if (removingArray === 'sanityGain') {
        localCharacter.value.sanityGain.pop()
    } else if (removingArray === 'sanityLoss') {
        localCharacter.value.sanityLoss.pop()
    }

    emit('update:characterData')
}
function addFromSanity(addArray) {
    if (addArray === 'sanityGain') {
        localCharacter.value.sanityGain.push('')
    } else if (addArray === 'sanityLoss') {
        localCharacter.value.sanityLoss.push('')
    }

    emit('update:characterData')
}
</script>

<style scoped lang="scss">
.defaultContainer {
    gap: 40px;
    flex-direction: row;
    >.innerContainer {
        width: 100%;
        &.sanityGain {
            background-color: var(--colorSanityGain);
        }

        &.sanityLoss {
            background-color: var(--colorSanityLoss);
        }

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
