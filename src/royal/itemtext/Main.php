<?php
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
        $item = $entity->getItem();
        $iname = $item->getName();
        $icount = $item->getCount();
        $display = str_replace(['{count}', '{item-name}'], [$icount, $iname], $this->text);
        $entity->setNameTag($display);
        $entity->setNameTagVisible(true);
        $entity->setNameTagAlwaysVisible(true);
    }

}