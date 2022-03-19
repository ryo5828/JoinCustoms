<?php

namespace ryo5828\JoinCustoms;


use pocketmine\plugin\PluginBase;

use pocketmine\player\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

use pocketmine\entity\effect\Effect;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;


class Main extends PluginBase implements Listener {

    private $config;
    /** Plugin有効時 */
    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig(); # DefaultConfigをsave
    }
    /** Player入室時 */
    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();

        /** PopMessage 送信 */
        $message = $this->getConfig()->getNested("message.JoinServerMessage");
        $player->sendPopup($message);

        /** Item付与 */
        $itemInstance = $this->getConfig()->getNested("item.item1");
        $item = ItemFactory::getInstance()->get($itemInstance, 0); // idでアイテムオブジェクト取得
        $item->setCustomName($this->getConfig()->getNested('item.name1')); // アイテム名を変更

        if(!($player->getInventory()->contains($item))){ // inventoryに同じアイテムがなければ追加
            $player->getInventory()->addItem($item);
        }

        /** Item付与 */
        $itemInstance = $this->getConfig()->getNested("item.item2");
        $item = ItemFactory::getInstance()->get($itemInstance, 0); // idでアイテムオブジェクト取得
        $item->setCustomName($this->getConfig()->getNested('item.name2')); // アイテム名を変更

        if(!($player->getInventory()->contains($item))){ // inventoryに同じアイテムがなければ追加
            $player->getInventory()->addItem($item);
        }

        /** 暗視付与 */
        if($this->getConfig()->getNested("NIGHT_VISION.effect")) {
            $player->getEffects()->add(
                new EffectInstance(
                    VanillaEffects::NIGHT_VISION(),
                    $this->getConfig()->getNested("NIGHT_VISION.duration"), // tick
                    $this->getConfig()->getNested("NIGHT_VISION.level"), // レベル
                    $this->getConfig()->getNested("NIGHT_VISION.particle") // パーティクル
                )
            );
        }
    }
}
