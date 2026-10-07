<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

/** @since v41 */
class PacketIds{

    private function __construct(){}

    public const LOGIN = 143;
    public const PLAY_STATUS = 144;
    public const DISCONNECT = 145;
    public const BATCH = 146;
    public const TEXT = 147;
    public const SET_TIME = 148;
    public const START_GAME = 149;
    public const ADD_PLAYER = 150;
    public const REMOVE_PLAYER = 151;
    public const ADD_ENTITY = 152;
    public const REMOVE_ENTITY = 153;
    public const ADD_ITEM_ENTITY = 154;
    public const TAKE_ITEM_ENTITY = 155;
    public const MOVE_ENTITY = 156;
    public const MOVE_PLAYER = 157;
    public const REMOVE_BLOCK = 158;
    public const UPDATE_BLOCK = 159;
    public const ADD_PAINTING = 160;
    public const EXPLODE = 161;
    public const LEVEL_EVENT = 162;
    public const BLOCK_EVENT = 163;
    public const ENTITY_EVENT = 164;
    public const MOB_EFFECT = 165;
    public const UPDATE_ATTRIBUTES = 166;
    public const MOB_EQUIPMENT = 167;
    public const MOB_ARMOR_EQUIPMENT = 168;
    public const INTERACT = 169;
    public const USE_ITEM = 170;
    public const PLAYER_ACTION = 171;
    public const HURT_ARMOR = 172;
    public const SET_ENTITY_DATA = 173;
    public const SET_ENTITY_MOTION = 174;
    public const SET_ENTITY_LINK = 175;
    public const SET_HEALTH = 176;
    public const SET_SPAWN_POSITION = 177;
    public const ANIMATE = 178;
    public const RESPAWN = 179;
    public const DROP_ITEM = 180;
    public const CONTAINER_OPEN = 181;
    public const CONTAINER_CLOSE = 182;
    public const CONTAINER_SET_SLOT = 183;
    public const CONTAINER_SET_DATA = 184;
    public const CONTAINER_SET_CONTENT = 185;
    public const CRAFTING_DATA = 186;
    public const CRAFTING_EVENT = 187;
    public const ADVENTURE_SETTINGS = 188;
    public const BLOCK_ENTITY_DATA = 189;
    public const FULL_CHUNK_DATA = 191;
    public const SET_DIFFICULTY = 192;
    public const SET_PLAYER_GAMETYPE = 194;
    public const PLAYER_LIST = 195;
}
