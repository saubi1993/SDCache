<?php
namespace SDClient;

class SDClient
{
	private $SDClientProvider;
	private $configPath;
	private $serviceInstances;

	public function __construct($SDClientProvider, $configPath) {
		$this->SDClientProvider = $SDClientProvider;
		$this->configPath = $configPath;
	}

	public function discover($service, $tag = null, $endpoint = null) {
		$serviceInstances = $this->getServiceInstances($service, $tag);
		return $this->SDClientProvider->getClient($serviceInstances, $tag, $endpoint);
	}

	public function discoverAll($service, $tag = null) {
		return $this->getServiceInstances($service, $tag);
	}

	private function getServiceInstances($service, $tag = null) {
		if (!isset($this->serviceInstances[$service])) {
			
			$phpFile = $this->configPath . "/php/$service.php";
			$jsonFile = $this->configPath . "/json/$service.json";
			
			$information =$this->includePhp($phpFile);
			if ($information == null || !is_array($information) || count($information) == 0) {
				$information =$this->includeJson($jsonFile);
				if (!is_array($information) || count($information) == 0) {
					throw new SDConfigNotFoundException("Content Missing in Service Configs \n");
				} 
			}
			$this->serviceInstances[$service] = $information;
		}

		return $this->getFormattedServiceInstances($this->serviceInstances[$service],$tag);
	}

	private function includePhp($phpFile) {
		if (file_exists($phpFile)) {
				require $phpFile;
				return $information;
		} 
		return null;
	}

	private function includeJson($jsonFile) {
		if (file_exists($jsonFile)) {
				require $jsonFile;
				$json = trim(file_get_contents($jsonFile));
				return json_decode($json, true);
		} 
		throw new SDConfigNotFoundException("Service Config file does not exist \n");
	}

	private function getFormattedServiceInstances($serviceInstances, $tag = null) {
		if (empty($tag)) {
			$untaggedConfig = array();

			foreach ($serviceInstances as $tag => $instances) {
				foreach ($instances as $idx => $value) {
					$untaggedConfig[] = $instances[$idx];
				}
			}

			return $untaggedConfig;
		}
		else {
			if(isset($serviceInstances[$tag]))
				return $serviceInstances[$tag];
			throw new SDConfigNotFoundException("Tag does not exist \n");
		}
	}
}

