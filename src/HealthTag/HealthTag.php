<?php

namespace HealthBarIN;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class HealthTag extends PluginBase implements Listener{
		
	public function onEnable(){ 
		$this->getLogger()->info(TextFormat::YELLOW."Loading up Infernal HealthBar");
		$this->isEnabled = true;
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info(TextFormat::GREEN."Infernal HealthBar by EmeraldYT");
	}

	public function onDisable(){
		$this->getLogger()->info("Infernal Health Bar Disabled..");
	}
	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		
		$this->renderNametag($player);
	}

	public function renderNameTag($player){
		$username = $player->getName();
		
		if($this->isEnabled){
			$player->setNameTag(TextFormat::GRAY.$player->getName().TextFormat::WHITE." ".$player->getHealth().TextFormat::GREEN."❤");
		}else{
			$player->setNameTag($player->getName());
		}
	}
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		$username = $sender->getName();
		switch($command->getName()){
			case "inhb":
				if($sender->isOp()){
					if($this->isEnabled !== false){
						$this->isEnabled = false;
					}else{
						$this->isEnabled = true;
					}
					foreach($this->getServer()->getOnlinePlayers() as $player){
						$this->renderNameTag($player);
					}
				}else{
					$sender->sendMessage(TextFormat::GOLD."This Command Requires Permision OP!");
				}
				return true;
			break;
		}
	}
	
	public function onEntityDamage(EntityDamageEvent $event){
		$entity = $event->getEntity();
		if($entity instanceof Player){
			$player = $entity->getPlayer();
			$this->renderNameTag($player);
		}
	}
	
	public function onEntityRegainHealth(EntityRegainHealthEvent $event){
		$entity = $event->getEntity();
		if($entity instanceof Player){
			$player = $entity->getPlayer();
			$this->renderNameTag($player);
		}
	}
}
