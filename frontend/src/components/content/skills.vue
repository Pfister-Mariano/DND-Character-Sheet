<template>
    <div class="skillWrapper">
        <div class="skill" v-for="(skill, skillIndex, loopIndex) in localCharacter.skills">
            <div class="ability">
                <div class="abilityContainer">
                    <div class="modifier">
                        <h3 v-if="skill.abilityScore > 11">+{{ Math.floor((skill.abilityScore - 10) / 2) }}</h3>
                        <h3 v-else>{{ Math.floor((skill.abilityScore - 10) / 2) }}</h3>
                    </div>
                    <input class="score" v-model="skill.abilityScore" type="number" @input="updateCharacterData"></input>
                </div>
                <h2>
                    {{ skill.abilityName }}
                </h2>
            </div>
            <div class="skillList">
                <div class="skill" v-for="(ability, abilityIndex) in Object.entries(skill).slice(2)">
                    <Toggle :class="'proficiencyButton'" :defaultValue="ability[1].proficient"
                    @click="toggleProficiency(ability)"></Toggle>
                    <Toggle :class="'proficiencyButton'"  :defaultValue="ability[1].expertise" 
                    @click="toggleExpertise(ability)"></Toggle>
                    <input type="text" v-model="ability[1].skillName">
                    <div class="multiRoll">
                        <div class="multiRollIndicator" :class="{ active: ability[1].disadvantage }" @click="ability[1].disadvantage = !ability[1].disadvantage">
                            <svg width="19" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.6 0 0 8l4.6 8h9.2l4.6-8-4.6-8H4.6Z" fill="#DC2626"/><path d="M8.563 13H5.267V2.818h3.4c.998 0 1.855.204 2.57.612a4.03 4.03 0 0 1 1.646 1.745c.385.755.577 1.662.577 2.72 0 1.06-.194 1.971-.582 2.734a4.082 4.082 0 0 1-1.67 1.76c-.73.407-1.61.611-2.645.611Zm-1.76-1.342H8.48c.775 0 1.42-.146 1.933-.438.514-.295.899-.72 1.154-1.278.255-.56.383-1.242.383-2.048 0-.799-.128-1.476-.383-2.033a2.705 2.705 0 0 0-1.129-1.268c-.5-.288-1.122-.432-1.864-.432h-1.77v7.497Z" fill="#fff"/></svg>
                        </div>
                        <div class="multiRollIndicator" :class="{ active: ability[1].advantage }" @click="ability[1].advantage = !ability[1].advantage">
                            <svg width="19" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.9 0 .3 8l4.6 8h9.2l4.6-8-4.6-8H4.9Z" fill="#22C55E"/><path d="M6.577 13h-1.63L8.61 2.818h1.775L14.05 13h-1.631L9.54 4.668h-.08L6.578 13Zm.274-3.987h5.29v1.292H6.85V9.013Z" fill="#fff"/></svg>
                        </div>
                    </div>
                    <div class="modifier">
                        <span>
                            {{ (abilityModifier =
                                (Math.floor((skill.abilityScore - 10) / 2))
                                + ability[1].extraModifier
                                + Number(ability[1].proficient ? localCharacter.proficiencyBonus : 0)
                                + Number(ability[1].expertise ? localCharacter.proficiencyBonus : 0)
                                )
                            }}
                        </span>
                        <span :class="abilityModifier >= 1 ? 'positiveModifier' : ''" >{{ abilityModifier >= 0 ? '+' : '' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';
import { Toggle } from '@/components/ui/toggle'

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
    // const newSize = Number(event.target.value);    
    emit('update:characterData');
}

function toggleProficiency(ability) {
    ability[1].proficient = !ability[1].proficient;
    updateCharacterData();
}

function toggleExpertise(ability) {
    ability[1].expertise = !ability[1].expertise;
    updateCharacterData();
}

</script>

<style scoped lang="scss">
.skillWrapper {
    display: flex;
    flex-direction: column;
    gap: 40px;

    .ability {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: nowrap;
        margin-bottom: 32px;

        .abilityContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            .modifier {
                background-color: var(--colorBG3);
                display: flex;
                justify-content: center;
                align-items: center;
                width: 60px;
                height: 60px;
                border-radius: 6px;

                h3 {
                    font-weight: 400;
                }
            }

            .score {
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
                height: 24px;
                width: 35px;
                background-color: var(--colorBlueDark);
                z-index: 3;
                border-radius: 3px;
                position: absolute;
                bottom: -12px;
            }
        }
    }
    .skillList{
        display: flex;
        flex-direction: column;
        gap: 10px;
        .skill{
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            background-color: var(--colorBG3);
            border-radius: 3px;

            .proficiencyButton{
                padding: 0;
                margin: 0;
                height: 16px;
                width: 16px;
                border-radius: 50%;
                &[data-state="off"]{
                    background-color: var(--colorWhite);
                }
                &::after{
                    display: block;
                    content: '';
                    width: 62%;
                    height: 62%;
                    border-radius: 50%;
                    background-color: var(--colorBlueDark);
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    opacity: 0;
                    transition: var(--transition);
                    pointer-events: none;
                }
                &[data-state="on"]::after{
                    opacity: 1;
                }
            }
            > input{
                flex-grow: 1;
                padding-left: 5px;
                width: 80px;
            }
            .multiRoll{
                display: flex;
                gap: 5px;
                .multiRollIndicator{
                    opacity: 0;
                    order: 0;
                    transition: var(--transition);
                    cursor: pointer;
                    &:hover{
                        opacity: .5;
                    }
                    &.active{
                        opacity: 1;
                        order: 1;
                    }
                }
            }
            .modifier{
                height: 20px;
                width: 30px;
                display: flex;
                flex-direction: row-reverse;
                justify-content: center;
                align-items: center;
                border-radius: 3px;
                background-color: var(--colorBG4);
                &:has(.positiveModifier:nth-child(2)){
                    background-color: var(--colorBlueDark);
                }
            }
        }
    }
}
</style>
