<template>
    <div class="battleView">
        <div class="battleViewGrid">
            <div v-for="(abilities, useTime) in sortedGroupedAbilities(groupedAbilities)" :key="useTime" class="defaultContainer">
                <h3>{{ useTime }}</h3>
                <div class="innerContainer accordion" v-for="(ability, index) in abilities" :key="index" :style="{'order': ability.order}">
                    <div class="accordionHead">
                        <div class="accordionToggle" @click="toggleAccordion($event)">
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="accordionTitle">
                            <input type="text" v-model="ability.name" @input="updateCharacterData">
                        </div>
                        <div class="accordionLevel">
                            <input type="text" v-model="ability.levelRequirement" @input="updateCharacterData">
                        </div>
                    </div>
                    <div class="accordionContent">
                        <div class="accordionHighlights">
                            <div>
                                <input type="text" v-model="ability.origin" @input="updateCharacterData">
                            </div>
                            <div>
                                <input type="text" v-model="ability.useTime" @input="updateCharacterData">
                            </div>
                        </div>
                        <div class="accordionText">
                            <ckEditorSmall :editorText="ability.description" :editorIndex="index"
                                @update:editorText="(newContent, index) => updateText(newContent, index)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref, watch, defineEmits } from 'vue';
import ckEditorSmall from '../ckEditorSmall.vue';

const props = defineProps({
    characterData: {
        type: Object,
        required: true,
    },
});

const localCharacter = ref(props.characterData);

watch(localCharacter, (newVal) => {
    localCharacter.value = newVal;
    props.characterData = newVal;
});

const emit = defineEmits(['update:characterData']);

function updateCharacterData(event) {
    const newSize = Number(event.target.value);
    emit('update:characterData', newSize);
}

function toggleAccordion(event) {
    const accordionElement = event.target.closest('.accordion');
    if (accordionElement) {
        accordionElement.classList.toggle('active');
    }
}

const groupedAbilities = computed(() => {
    return localCharacter.value.abilities.reduce((groups, ability) => {
        const useTime = ability.useTime || 'Unknown';
        if (!groups[useTime]) {
            groups[useTime] = [];
        }
        groups[useTime].push(ability);
        
        return groups;
    }, {});
});
function sortedGroupedAbilities(group) {
    return Object.keys(group)
    .sort((a, b) => a.localeCompare(b)) 
    .reduce((acc, key) => {
        acc[key] = group[key];
        return acc;
    }, {});
}
function updateText(newContent, index) {
    localCharacter.value.abilities[index].description = newContent.value;
    emit('update:characterData');
}
</script>

<style scoped lang="scss">
.battleView {
  container-type: inline-size;
}

.battleViewGrid{
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 30px;

    @container (max-width: 900px) {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    @container (max-width: 500px) {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}

.defaultContainer h3{
    margin-bottom: 10px;
}

.innerContainer.accordion {
    padding: 0;
    gap: 0;
    background-color: var(--colorBG3);
    .accordionContent .accordionHighlights div{
        background-color: var(--colorBG1);
    }
    .accordionHead {
        .accordionToggle i{
            color: var(--colorBG1);
        }
        .accordionLevel{
            background-color: var(--colorBG1);
        }
    }


    .accordionHead {
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 1.20rem;

        .accordionToggle {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 5px;
            cursor: pointer;

            i {
                font-size: 1.2rem;
                transform: rotate(-90deg);
                transition: var(--transition);
            }
        }

        .accordionTitle {
            width: 100%;
            padding: 5px 0 5px 5px;

            input {
                width: 100%;
                letter-spacing: 0.05em;
            }
        }

        .accordionLevel {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 26px;
            width: 120px;
            margin: 5px 10px;
            color: var(--colorWhite);
            border-radius: 6px;

            input {
                width: 100%;
                padding: 0;
                line-height: 20px;
                text-align: center;
            }
        }
    }

    .accordionContent {
        margin-top: 0px;
        padding: 0 10px;
        overflow: hidden;
        height: 0;
        display: flex;
        flex-direction: column;
        gap: 5px;

        .accordionHighlights {
            display: flex;
            gap: 5px;

            div {
                width: 100%;
                padding: 5px 10px;
                border-radius: 6px;

                input {
                    width: 100%;
                    text-align: center;
                }
            }
        }

        .accordionText {
            min-height: 1lh;
        }
    }

    &.active {
        i {
            transform: rotate(0deg) !important;
        }

        .accordionContent {
            margin-top: 10px;
            padding: 0 10px 10px 10px;
            height: auto;
        }
    }
}


/* .accordionAdd {
    background-color: var(--colorBlueDark);
    border-radius: 6px;
    height: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0.25;
    margin-top: 10px;
    transition: var(--transition);
    cursor: pointer;

    &:hover {
        opacity: 1;
    }
} */
</style>