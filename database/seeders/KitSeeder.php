<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kit;

class KitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kits = [
            [
                'kit_name' => 'Router',
                'description' => 'A router is a device that connects multiple networks and directs data packets between them. It manages traffic by forwarding data to the intended IP addresses and enables multiple devices to share a single Internet connection.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Access Point',
                'description' => 'An access point is a device that connects wireless client devices to a wired network. It acts as a bridge between wireless clients and the wired network, providing network access and enhancing wireless coverage.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Switch',
                'description' => 'A network switch is a device that connects multiple devices on a network and directs data packets to the appropriate devices based on their MAC addresses. It improves network efficiency and manages data traffic effectively.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Touch Panel',
                'description' => 'A touch panel is an input device that allows users to interact with a computer or system through touch input. It can be used for controlling various functions and applications with a simple touch interface.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Computer',
                'description' => 'A computer is a versatile device used for a wide range of tasks, including data processing, internet browsing, and software applications. This entry represents multiple computers available for use.',
                'quantity' => 50,
            ],
            [
                'kit_name' => 'Modular Box',
                'description' => 'A modular box is a container used for organizing and housing various components, such as cables, connectors, and network equipment. It helps in maintaining a tidy and manageable setup.',
                'quantity' => 1,
            ],
            [
                'kit_name' => 'Cisco Switch 2960',
                'description' => 'The Cisco Switch 2960 is a network switch that provides reliable and high-performance connectivity for various network devices. It is suitable for enterprise environments and supports advanced network features.',
                'quantity' => 1,
            ],
            [
                'kit_name' => 'Cisco Router 2610',
                'description' => 'The Cisco Router 2610 is a versatile router designed for routing data between networks. It offers robust performance and supports a range of networking features to facilitate efficient data management.',
                'quantity' => 2,
            ],
            [
                'kit_name' => 'Cisco Router 2651',
                'description' => 'The Cisco Router 2651 is a router used for routing data between networks, providing enhanced connectivity and performance for networking tasks. It is suitable for medium to large-scale network environments.',
                'quantity' => 2,
            ],
            [
                'kit_name' => 'Epson Printer 5290',
                'description' => 'The Epson Printer 5290 is a high-quality printer designed for printing documents and images with excellent clarity and color accuracy. It is suitable for both home and office use.',
                'quantity' => 1,
            ],
            [
                'kit_name' => 'Epson Printer 6190',
                'description' => 'The Epson Printer 6190 is an advanced printer that offers high-resolution printing for professional-quality documents and photos. It is ideal for users who require reliable and high-performance printing capabilities.',
                'quantity' => 1,
            ],
            [
                'kit_name' => 'Computer Table',
                'description' => 'A computer table is a piece of furniture designed to hold computer equipment and accessories. It provides a stable and ergonomic workspace for computing tasks.',
                'quantity' => 20,
            ],
            [
                'kit_name' => 'Philip Screw Driver',
                'description' => 'A Philip screwdriver is a hand tool used for driving screws with a cross-shaped (Phillips) head. It is essential for assembling and disassembling various components and equipment.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Flat Screw Driver',
                'description' => 'A flat screwdriver is a hand tool used for driving screws with a single flat head. It is commonly used for various mechanical and electrical tasks.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Crimping Tool',
                'description' => 'A crimping tool is used to attach connectors to cables or wires by deforming the connector onto the wire. It is essential for creating secure and reliable electrical connections.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Krone (Punch Down Tool)',
                'description' => 'A Krone punch down tool is used to insert and trim insulation-displacement connectors into a punch-down block. It is commonly used in network installations to ensure proper connections.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Manual Puncle',
                'description' => 'A manual puncle is a hand tool used for punching holes in various materials, including paper and plastic. It is useful for creating holes for binding or other purposes.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Function Stripper',
                'description' => 'A function stripper is a tool used for stripping insulation from electrical wires. It allows for precise removal of insulation without damaging the wire itself.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'UTP Stripper',
                'description' => 'A UTP stripper is used specifically for stripping the insulation from unshielded twisted pair (UTP) cables. It is essential for preparing cables for network connections.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'Container',
                'description' => 'A container is a versatile storage solution used to organize and protect various items, including tools, components, and accessories. It helps in maintaining an orderly workspace.',
                'quantity' => 10,
            ],
            [
                'kit_name' => 'LAN Tester',
                'description' => 'A LAN tester is a device used to test and diagnose network cables and connections. It helps in identifying issues with network cables and ensuring proper connectivity.',
                'quantity' => 10,
            ],
        ];

        foreach ($kits as $kit) {
            Kit::create($kit);
        }
    }
}
