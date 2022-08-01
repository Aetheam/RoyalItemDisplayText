<?php

//code use for update to pm4 and for add configuration
//base source code : https://github.com/DaRealAqua/ItemDisplay
namespace royal\itemtext;

use pocketmine\event\entity\ItemSpawnEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener{
    private string $text;
    protected function onEnable(): void
    {
        $this->saveDefaultConfig();
        $config = new Config($this->getDataFolder()."config.yml");
        $this->text = $config->get("text");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info("Have you a bug ? please contact me in my shop discord: https://discord.gg/yv7bQujyCN");
    }
    public function drop(ItemSpawnEvent $event){

        $entity = $event->getEntity();
        $entities = $event->getEntity()->getWorld()->getNearbyEntities($entity->getBoundingBox()->expandedCopy(5, 5, 5));

        if(empty($entities)) {
            return;
        }
        if($entity instanceof ItemEntity) {
            $originalItem = $entity->getItem();
            foreach($entities as $e) {
                if($e instanceof ItemEntity and $entity->getId() !== $e->getId()) {
                    $item = $e->getItem();
                    if($item->getId() === $originalItem->getId()) {
                        $e->flagForDespawn();
                        $entity->getItem()->setCount($originalItem->getCount() + $item->getCount());
                    }
                }
            }
        }
        $item = $entity->getItem();
        $iname = $item->getName();
        $icount = $item->getCount();
        $display = str_replace(['{count}', '{item-name}'], [$icount, $iname], $this->text);
        $entity->setNameTag($display);
        $entity->setNameTagVisible(true);
        $entity->setNameTagAlwaysVisible(true);
    }

}
