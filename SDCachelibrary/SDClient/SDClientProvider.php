<?php
namespace SDClient;

class SDClientProvider
{
	public function getClient($serviceInstances, $tag = null, $endpoint = null) {
		$totalWeight = 0;
		$cumulativeWeight = array();

		foreach ($serviceInstances as $instance) {
			$totalWeight = $totalWeight + $instance["weight"];
			$cumulativeWeight[] = $totalWeight;
		}
		$random = mt_rand(1, $totalWeight);

		foreach ($cumulativeWeight as $idx => $weight) {
			if ($random <= $weight) {
				unset($serviceInstances[$idx]["weight"]);
				return $this->getServiceEndPoint($serviceInstances[$idx], $endpoint);
			}
		}

		throw new SDConfigNotFoundException('Config not found.');
	}

	private function getServiceEndPoint($instance, $endpoint = null) {
		if ($endpoint==null) {
			return $instance;
		}
		else {
			if(isset($instance['endpoints'][$endpoint])) {
						$instance['endpoints'] = $instance['endpoints'][$endpoint];
						return $instance;
				}
			}
		throw new SDConfigNotFoundException("Endpoint not found.\n");
		
	}
}

