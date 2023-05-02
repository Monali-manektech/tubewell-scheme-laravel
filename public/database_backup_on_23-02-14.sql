

CREATE TABLE `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_no` varchar(191) NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `link` varchar(191) DEFAULT NULL,
  `discipline` varchar(191) DEFAULT NULL,
  `legend` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `units` int(11) DEFAULT NULL,
  `quantity` double(8,2) DEFAULT NULL,
  `rate` double(16,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('1','1.01','','2','mech','Survey','All the works including Hydrological survey, topographical survey, Design charges including preparation and approval of DPR
','1','1','27819133','2023-02-13 08:56:54','2023-02-13 09:02:50');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('2','2','','3','Civil','Borewell ','Drilling  of Borehole for Tubewell construction by DC/RC/DTH Rig Machine including transportaion, erection, dismantling of Rig and assosiated T&P complete in all respect including required all material labour etc.','1','1','1','2023-02-13 08:56:54','2023-02-13 09:03:37');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('3','2.01','2','4','Civil','Borewell ','Transportation, Installation Dismantling of Rig machine and logging  of bore hole','1','1','143168','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('4','2.02','2','5','Civil','Borewell ','Tube well construction','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('5','2.03','2','6','Civil','Borewell ','DC/RC Drilling up to 100Mtr.','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('6','2.04','2','7','Civil','Borewell ','400 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('7','2.05','2','8','Civil','Borewell ','450 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('8','2.06','2','9','Civil','Borewell ','500 MMØ','1','1','2102','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('9','2.07','2','10','Civil','Borewell ','600 MMØ','1','100','2507.74','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('10','2.08','2','11','Civil','Borewell ','DC/RC Drilling from 101 Mtr. To 200 Mtr.Deep','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('11','2.09','2','12','Civil','Borewell ','450 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('12','2.1','2','13','Civil','Borewell ','500 MMØ','1','1','2429.41','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('13','2.11','2','14','Civil','Borewell ','600 MMØ','1','60','2844.41','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('14','2.12','2','15','Civil','Borewell ','DC/RC Drilling from 201 Mtr. To 300 Mtr.Deep','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('15','2.13','2','16','Civil','Borewell ','450 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('16','2.14','2','17','Civil','Borewell ','500 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('17','2.15','2','18','Civil','Borewell ','600 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('18','2.16','2','19','Civil','Borewell ','DC/RC Drilling from 301 Mtr. To 400 Mtr.Deep & above','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('19','2.17','2','20','Civil','Borewell ','450 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('20','2.18','2','21','Civil','Borewell ','500 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('21','2.19','2','22','Civil','Borewell ','600 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('22','2.2','2','23','Civil','Borewell ','DTH Drilling upto 200.0 Mtr.Deep','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('23','2.21','2','24','Civil','Borewell ','200/165 MMØ (in over burden/Hard Rock)','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('24','2.22','2','25','Civil','Borewell ','Development / Flushing of tubewell','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('25','3','','26','mech','Borewell ','Tubwell Assembly:','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('26','3.01','25','27','mech','Borewell ','MSERW plain pipe, As per IS 4270 and as per design requirement approved by Engineer Incharge.','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('27','3.02','25','28','Mech','Borewell ','100 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('28','3.03','25','29','Mech','Borewell ','150 MMØ','1','1','1900','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('29','3.04','25','30','Mech','Borewell ','200 MMØ','1','37','2550','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('30','3.05','25','31','Mech','Borewell ','300 MMØ','1','60','3800','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('31','3.06','25','32','Mech','Borewell ','MSERW Pipe  slotted pipe  as  per IS 8110','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('32','3.07','25','33','Mech','Borewell ','100 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('33','3.08','25','34','Mech','Borewell ','150 MMØ','1','1','2800','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('34','3.09','25','35','Mech','Borewell ','200 MMØ','1','48','3833.8','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('35','3.1','25','36','Mech','Borewell ','300 MMØ','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('36','3.11','25','37','Mech','Borewell ','MS fittings such as  clamp, bail plug, reducer, well cap, girder & support structure','1','1','32295','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('37','3.12','25','38','Mech','Borewell ','MS fittings such as ring & centre guide','1','145','471.68','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('38','4','','39','Civil / Mech','Borewell ','Lowering of above assembly with welding of parts complete in all respect with all required material, T&P, labour, etc.','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('39','4.01','38','40','Civil / Mech','Borewell ','Lowering up to 100 Mtr. Deep','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('40','4.02','38','41','Civil / Mech','Borewell ','100 MMØ MSERW Plane/Slotted Pipe','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('41','4.03','38','42','Civil / Mech','Borewell ','150 MMØ MSERW Plane/Slotted Pipe','1','1','343','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('42','4.04','38','43','Civil / Mech','Borewell ','200 MMØ MSERW Plane/Slotted Pipe','1','40','388','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('43','4.05','38','44','Civil / Mech','Borewell ','300 MMØ MSERW Plain/Slotted Pipe','1','60','433','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('44','4.06','38','45','Civil / Mech','Borewell ','Lowering from 101 Mtr. To 200 Mtr. Deep','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('45','4.07','38','46','Civil / Mech','Borewell ','150 MMØ MSERW Plane/Slotted Pipe','1','1','376','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('46','4.08','38','47','Civil / Mech','Borewell ','200 MMØ MSERW Plane/Slotted Pipe','1','45','499.19','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('47','4.09','38','48','Civil / Mech','Borewell ','300 MMØ MSERW Plane/Slotted Pipe','1','1','745.58','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('48','4.1','38','49','Civil / Mech','Borewell ','Lowring from 201 Mtr. To 300 Mtr. Deep','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('49','4.11','38','50','Civil / Mech','Borewell ','150 MMØ MSERW Plane/Slotted Pipe','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('50','4.12','38','51','Civil / Mech','Borewell ','200 MMØ MSERW Plane/Slotted Pipe','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('51','4.13','38','52','Civil / Mech','Borewell ','300 MMØ MSERW Plane/Slotted Pipe','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('52','4.14','38','53','Civil / Mech','Borewell ','Lowring from 301 Mtr. To 400 Mtr. Deep & above','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('53','4.15','38','54','Civil / Mech','Borewell ','150 MMØ MSERW Plane/Slotted Pipe','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('54','4.16','38','55','Civil / Mech','Borewell ','200 MMØ MSERW Plane/Slotted Pipe','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('55','4.17','38','56','Civil / Mech','Borewell ','300 MMØ MSERW Plane/Slotted Pipe','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('56','5','','57','Civil','Borewell ','Supplying and unconsolidated packing of gravel with suitable size','1','57.47','7500','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('57','6','','58','Civil','Borewell ','Development of Tube well','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('58','6.01','57','59','Civil','Borewell ','Tranportation, Installation Dismantling of 150 PSI Compressor','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('59','6.02','57','60','Civil','Borewell ','Charges for Development by 150 PSI Compressor per hour','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('60','6.03','57','61','Civil','Borewell ','Tranportation, Installation Dismantling of 250/400/600 PSI Compressor','1','1','50866','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('61','6.04','57','62','Civil','Borewell ','Charges for Development by 250 PSI Compressor per hour','1','40','3337','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('62','6.05','57','63','Civil','Borewell ','Charges for Development by 400 PSI Compressor per hour','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('63','6.06','57','64','Civil','Borewell ','Charges for Development by 600 PSI Compressor per hour','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('64','6.07','57','65','Civil','Borewell ','Tranportation, Installation Dismantling of 0.5 Cusec OP Unit and Yield test, water test','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('65','6.08','57','66','Civil','Borewell ','Charges for Development of TW by 0.5 Cusec OP Unit','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('66','6.09','57','67','Civil','Borewell ','Tranportation, Installation Dismantling of 1/3 Cusec OP Unit and Yield test, water test','1','1','77126','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('67','6.1','57','68','Civil','Borewell ','Charges for Development of TW by 1 cusec OP Unit','1','1','994.43','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('68','6.11','57','69','Civil','Borewell ','Charges for Development of TW by 3 cusec OP Unit','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('69','6.12','57','70','Civil','Borewell ','Tranportation, Installation Dismantling of 2 Cusec OP Unit and Yield test, water test','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('70','6.13','57','71','Civil','Borewell ','Charges for Development of TW by 2 cusec OP Unit','1','80','1119','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('71','6.14','57','72','','Borewell ','Zone Testing : Zone Testing in water quality problem areas including all required material, labour, T&P etc complete in all respect.','1','1','40000','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('72','7','','73','Mech/elec','Pumps & Fittings','SITC of Pumping plant including pumps with motors starter, pannel, cable, complete in all respect with all required material T&P labour etc.','1','1','1','2023-02-13 08:56:54','2023-02-13 09:04:51');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('73','7.11','72','84','Mech/elec','Pumps & Fittings','25 HP','1','1','334043.48','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('74','8','','89','elec','Borewell ','Pressure Transmitter','1','1','43120','2023-02-13 08:56:54','2023-02-13 09:06:41');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('75','8.01','74','','','Pumps & Fittings','Pressure & Depth Gauge','1','1','7440','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('76','9','','95','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 100 mm','1','1','125000','2023-02-13 08:56:54','2023-02-13 09:07:45');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('77','9.01','76','96','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 150 mm','1','1','125000','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('78','9.02','76','97','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 200 mm','1','1','150000','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('79','9.03','76','105','Mech','Pumps & Fittings','Check Valve PN 1.0 DPCV  dia 100 mm','1','1','27519.8','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('80','9.04','76','106','Mech','Pumps & Fittings','Check Valve PN 1.0 DPCV  dia 150 mm','1','1','51145.45','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('81','9.05','76','107','Mech','Pumps & Fittings','Check Valve PN 1.0 DPCV  dia 200 mm','1','1','73485.9','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('82','9.06','76','108','Mech','Dismantling Joint','Dismantling Joint PN 1.0 dia  100 mm','1','1','3923.92','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('83','9.07','76','109','Mech','Dismantling Joint','Dismantling Joint PN 1.0 dia  150 mm','1','1','5605.6','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('84','9.08','76','110','Mech','Dismantling Joint','Dismantling Joint PN 1.0 dia  200 mm','1','1','7367.36','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('85','9.09','76','113','Mech','Pumps & Fittings','SITC of Chain Pulley Blocks','1','1','1','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('86','9.1','76','114','Mech','Pumps & Fittings','1 Tonne','1','1','48305','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('87','9.11','76','115','Mech','Pumps & Fittings','2 Tonne','1','1','58432.5','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('88','10','','116','elec','Analyser','Turbidity & Chlorine analyzer','1','1','273000','2023-02-13 08:56:54','2023-02-13 09:08:33');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('89','11','','117','E&I','Analyser','Providing and installation hydrostatic level sensor at all tubewell pumping system including all accessories etc. complete in all respect as per instructions of Engineer ‐in –charge.','1','1','126000','2023-02-13 08:56:54','2023-02-13 09:12:13');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('90','12','','118','Test','Stabalizer','Stabalizer','1','1','1','2023-02-13 08:56:54','2023-02-13 09:13:46');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('91','12.01','90','119','E&I','Stabalizer','2 KVA','1','1','12777.78','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('92','12.02','90','120','E&I','Stabalizer','5 KVA','1','1','25555.56','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('93','12.03','90','121','E&I','Stabalizer','7.5 KVA','1','1','44722.22','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('94','12.04','90','122','E&I','Stabalizer','10 KVA','1','1','127777.78','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('95','12.05','90','123','E&I','Stabalizer','15 KVA','1','1','166111.11','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('96','12.06','90','124','E&I','Stabalizer','20 KVA','1','1','191666.37','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('97','12.07','90','125','E&I','Stabalizer','25 KVA','1','1','204444.44','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('98','12.08','90','126','E&I','Stabalizer','30 KVA','1','1','230000','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('99','12.09','90','127','E&I','Stabalizer','40 KVA','1','1','281111.11','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('100','12.1','90','128','E&I','Stabalizer','50 KVA','1','1','319444.44','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('101','12.11','90','129','E&I','Stabalizer','60 KVA','1','1','345000','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('102','13','','130','Mech','Pumps & Fittings','SITC of  Column pipe of MS pipe  for connecting submersible pumps','1','1','1','2023-02-13 08:56:54','2023-02-13 09:15:30');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('103','13.06','102','136','Mech','Pumps & Fittings','100 mm Dia size ‐ MS pipe','1','40','1567','2023-02-13 08:56:54','2023-02-13 08:56:54');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('104','14','','138','Process','Pumps & Fittings','Supply , Installation of chlorinating system with dosing pump 0‐6 LPH capacity with 100 Litres(1w+1s) tanks,valves ,pipes with required acessories (Automatic Dosing System for chemical injection)','1','1','112000','2023-02-13 08:56:54','2023-02-13 09:16:00');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('105','15','','139','Process','Process','Fluoride Removal Plant: Supplying, installation, testing, commissioning of Fluoride removal plant for required capacity including transportation and labour charges as complete. (vendor have to select the technology based on capacity (Electrolytic‐de fluoridation plant or media based system). Rates for400 KLD/ 500 LPM','1','1','8062500','2023-02-13 08:56:54','2023-02-13 09:16:48');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('106','16','','140','Process','Process','Iron Removal Plant: Supplying, installation, testing, commissioning of Iron removal plant which includes
vessel, media, piping valves etc. for required capacity including transportation and labour charges as complete.
Rates for400 KLD/ 500 LPM','1','1','6062500','2023-02-13 08:56:54','2023-02-13 09:20:56');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('107','17','','141','Process','Process','Arsenic Removal Plant: Supplying, installation, testing, commissioning of Arsenic removal plant which include vessel, media, piping valves etc. for required capacity including transportation and labour charges as complete. Rates for400 KLD/ 500 LPM','1','1','9000000','2023-02-13 08:56:54','2023-02-13 09:22:53');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('108','18','','142','Process','Process','TDS and Hardness removal Plant : Supplying, installation, testing, commissioning of reverse osmosis plant which includes pump, micron cartridge filter, high pressure pump ,reverse osmosis membrane, cleaning system and required piping and valves etc. complete for required capacity including transportation and labour charges as complete. Rates for400 KLD/ 500 LPM','1','1','13125000','2023-02-13 08:56:54','2023-02-13 09:22:27');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('109','19','','143','E&I','E & I','Internal electrificaton of tube well','1','1','20000','2023-02-13 08:56:54','2023-02-13 09:21:36');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('110','20','','144','E&I','Solar Plant','SITC of Solar power plant (for complete plant) including solar pannel, Structure, invertor etc. complete in all respect with required material, T&P labour','1','39','86800','2023-02-13 08:56:54','2023-02-13 09:22:07');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('111','21','','147','Civil','Boundary Wall','Construction of 1.3 m high and 115mm thick boundary wall with 230 mmx230 mm thick pillar made in Brick masonry in 1 cement and 4 sand mortar, the spacing between two pillar should not be more than 3.0 m c/c and the depth of foundation should not be less than 0.60m, at the site of water works as per departmental type design and drawing, and, as per specifications given in the bid document including supply of all materials, labour T&P etc.for proper completion of work as per instructions of Engineer ‐in ‐ charge. (Drawing No.D‐1)','1','130','6900','2023-02-13 08:56:54','2023-02-13 09:38:05');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('112','22','','148','Civil','Boundary Wall','Supply and fixing of 3.6 m x 1.20 m MS gate including fabrication and supply of steel and construction of bounary wall pillars of size 1.35mx0.23mx0.23m with ornamental brick work 115mm th. around RCC, as per departmental type design and drawing (Drawing No. D‐1) and as per specifications laid down in the bid document, including supply of all material,  labour,T&P etc.required for proper completion of work as per instructions of Engineer‐in‐charge.','1','1','52000','2023-02-13 08:56:54','2023-02-13 09:30:33');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('113','23','','149','Civil','Boundary Wall','Supply  and  fixing  of  1.2m  wide  MS  wicket  gate  including fabrication and supply of steel and construction of boundary wall pillars etc. as per specifications laid down in the bid document, including supply of all material, labour,T&P etc.required for proper completion of work as per instructions of Engineer‐in‐ charge.','1','1','19000','2023-02-13 08:56:54','2023-02-13 09:30:07');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('114','24','','150','Civil','Approach Road','Construction  of  Interlocking  pavement  for  approach  to  water works, as per departmental type design and drawing and as per specifications laid down in the bid document, including supply of all materials , labour, T&P etc.required for proper completion of work as per instructions of Engineer ‐in ‐charge.','1','102','1070.5','2023-02-13 08:56:54','2023-02-13 09:29:28');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('115','25','','151','Civil','Approach Road','Construction of granular sub base by providing coarse grade materials, spreading  in uniform layers
including watering and compaction complete.','1','15.3','2800','2023-02-13 08:56:54','2023-02-13 09:29:09');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('116','26','','152','Civil','Approach Road','Construction of WBM by providing grade materials, spreading  in uniform layers including watering and compaction complete.','1','1','3029','2023-02-13 08:56:54','2023-02-13 09:22:45');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('117','27','','153','Civil','Earth Filling','Earth filling work for proper leveling of water work site, in accordance with the contour map and Grid map of existing site enclosed (Drawing no.D‐1), including leveling, dressing, excavation  and  filling  of   earth where  necessary  and  also including all labour, materials, T&P etc.required for proper completion of works and also including carriage of earth from within a distance of about 8 km. from the site of works as per instructions of Engineer ‐in ‐ charge.','1','1','890','2023-02-13 08:56:54','2023-02-13 09:17:53');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('118','28','','154','Civil','Approach Road','Provision  for  inside  semicircular  drain  200mm  dia  including supply of all materials, labour and T & P etc. complete.','1','130','1607.14','2023-02-13 08:56:54','2023-02-13 09:17:31');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('119','29','','155','Civil','Pump House','Provide all materials, labour, T&P etc. complete and construct Pump house size (3.6x3.0x3.0)m Chlorinating room size (2.5x1.8x3.0)m as per departmental type design and drawing (drawing no‐D‐2) and as per the specifications for  civil  work given in the bid document, including supply of all material, labour and T&P etc complete as per instructions of Engineer ‐in ‐ charge.','1','1','525000','2023-02-13 08:56:54','2023-02-13 09:11:28');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('120','Additional Item','','90','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 32 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('121','Additional Item','','91','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 40 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('122','Additional Item','','92','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 50 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('123','Additional Item','','93','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 65 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('124','Additional Item','','94','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 80 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('125','Additional Item','','98','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 250 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('126','Additional Item','','99','Mech','Valves','Electrically operated Sluice Valve PN 1.0  dia 300 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('127','Additional Item','','100','Mech','Pumps & Fittings','Check Valve PN 1.0  DPCV dia 32 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('128','Additional Item','','101','Mech','Pumps & Fittings','Check Valve PN 1.0  DPCV dia 40 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('129','Additional Item','','102','Mech','Pumps & Fittings','Check Valve PN 1.0  DPCV dia 50 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('130','Additional Item','','103','Mech','Pumps & Fittings','Check Valve PN 1.0  DPCV dia 65 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('131','Additional Item','','104','Mech','Pumps & Fittings','Check Valve PN 1.0  DPCV dia 80 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('132','Additional Item','','111','Mech','Dismantling Joint','Dismantling Joint PN 1.0 dia  250 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('133','Additional Item','','112','Mech','Dismantling Joint','Dismantling Joint PN 1.0 dia  300 mm','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('134','Additional Item','','','','Pumps & Fittings','SITC of Electronic Type Chlorinating System','1','1','26000','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('135','Additional Item','','145','','Solar Plant','SITC of 2KW D.C./A.C. invertor, back by solar/electrical supply complete with 2000 watt  Solar plate, solar converter, 24 V Solar UPS etc. complete in all respect (For Auxiliary Load)','1','1','1','2023-02-13 08:56:54','');

INSERT INTO items (id, item_no, parent_id, link, discipline, legend, description, units, quantity, rate, created_at, updated_at) VALUES ('136','Additional Item','','146','','Solar Plant','500 watt battery for 2KW D.C./A.C. invertor, back by solar/electrical supply (For Auxiliary Load)','1','4','15000','2023-02-13 08:56:54','');


CREATE TABLE `item_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) unsigned NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `percentage` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('1','1','','','100','2023-02-13 09:02:50','2023-02-13 09:02:50');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('2','1','1','On completion of job','100','2023-02-13 09:02:50','2023-02-13 09:02:50');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('3','2','','','100','2023-02-13 09:03:37','2023-02-13 09:03:37');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('4','2','3','On Supply & delivery of complete RTU Panel & HMI System as per BOQ','70','2023-02-13 09:03:37','2023-02-13 09:03:37');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('5','2','3','Completion of Installation','20','2023-02-13 09:03:37','2023-02-13 09:03:37');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('6','2','3','Testing ','5','2023-02-13 09:03:37','2023-02-13 09:03:37');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('7','2','3','Commossioning','5','2023-02-13 09:03:37','2023-02-13 09:03:37');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('8','72','','','100','2023-02-13 09:04:51','2023-02-13 09:04:51');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('9','72','8','Supply of Tubewell Pumps with Motors Starter Panel','70','2023-02-13 09:04:51','2023-02-13 09:04:51');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('10','72','8','Supply of Cable for Tubewell set in all respect','10','2023-02-13 09:04:51','2023-02-13 09:04:51');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('11','72','8','On Completion of Installation and testing in all respect.','15','2023-02-13 09:04:51','2023-02-13 09:04:51');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('12','72','8','On Commissioning','5','2023-02-13 09:04:51','2023-02-13 09:04:51');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('13','74','','','100','2023-02-13 09:06:41','2023-02-13 09:06:41');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('14','74','13','Supply of Tubewell Pumps with Motors Starter Panel','70','2023-02-13 09:06:41','2023-02-13 09:06:41');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('15','74','13','Supply of Cable for Tubewell set in all respect','20','2023-02-13 09:06:41','2023-02-13 09:06:41');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('16','74','13','On Completion of Installation and testing in all respect.','5','2023-02-13 09:06:41','2023-02-13 09:06:41');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('17','74','13','On Commissioning','5','2023-02-13 09:06:41','2023-02-13 09:06:41');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('18','76','','','100','2023-02-13 09:07:45','2023-02-13 09:07:45');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('19','76','18','On Supply & Delivery','70','2023-02-13 09:07:45','2023-02-13 09:07:45');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('20','76','18','On Completion/Erection/Fixing/Laying/Jointing','20','2023-02-13 09:07:45','2023-02-13 09:07:45');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('21','76','18','On Completion of Testing','5','2023-02-13 09:07:45','2023-02-13 09:07:45');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('22','76','18','On Commissioning','5','2023-02-13 09:07:45','2023-02-13 09:07:45');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('23','88','','','100','2023-02-13 09:08:33','2023-02-13 09:08:33');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('24','88','23','On Supply & Delivery','70','2023-02-13 09:08:33','2023-02-13 09:08:33');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('25','88','23','On Completion/Erection/Fixing/Laying/Jointing','20','2023-02-13 09:08:33','2023-02-13 09:08:33');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('26','88','23','On Completion of Testing','5','2023-02-13 09:08:33','2023-02-13 09:08:33');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('27','88','23','On Commissioning','5','2023-02-13 09:08:33','2023-02-13 09:08:33');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('28','119','','Foundation up to plinth level','25','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('29','119','28','Excavation for Foundation','10','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('30','119','28','PCC for Foundation','5','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('31','119','28','RCC substructure work upto Plinth level','10','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('32','119','','Completion of superstructure','35','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('33','119','32','RCC Column upto roof slab','10','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('34','119','32','RCC for Slab','15','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('35','119','32','Fixing of Door, Windows Frame','10','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('36','119','','Finishing Civil work','20','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('37','119','36','Brick work & Plaster','15','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('38','119','36','Plinth Protection','5','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('39','119','','Electrical Installation','20','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('40','119','39','Electrical Works','10','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('41','119','39','Painting','10','2023-02-13 09:11:28','2023-02-13 09:11:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('42','89','','','100','2023-02-13 09:12:13','2023-02-13 09:12:13');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('43','89','42','On Supply & Delivery','70','2023-02-13 09:12:13','2023-02-13 09:12:13');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('44','89','42','On Completion/Erection/Fixing/Laying/Jointing','20','2023-02-13 09:12:13','2023-02-13 09:12:13');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('45','89','42','On Completion of Testing','5','2023-02-13 09:12:13','2023-02-13 09:12:13');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('46','89','42','On Commissioning','5','2023-02-13 09:12:13','2023-02-13 09:12:13');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('47','90','','','100','2023-02-13 09:13:46','2023-02-13 09:13:46');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('48','90','47','On Commissioning','5','2023-02-13 09:13:46','2023-02-13 09:13:46');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('49','90','47','On Completion of Testing','5','2023-02-13 09:13:46','2023-02-13 09:13:46');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('50','90','47','On Completion/Erection/Fixing/Laying/Jointing','20','2023-02-13 09:13:46','2023-02-13 09:13:46');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('51','90','47','On Supply & Delivery','70','2023-02-13 09:13:46','2023-02-13 09:13:46');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('58','102','56','On Completion/Erection/Fixing/Laying/Jointing','20','2023-02-13 09:15:30','2023-02-13 09:15:30');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('56','102','','','100','2023-02-13 09:15:30','2023-02-13 09:15:30');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('57','102','56','On Supply & Delivery','70','2023-02-13 09:15:30','2023-02-13 09:15:30');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('59','102','56','On Completion of Testing','5','2023-02-13 09:15:30','2023-02-13 09:15:30');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('60','102','56','On Commissioning','5','2023-02-13 09:15:30','2023-02-13 09:15:30');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('61','104','','','100','2023-02-13 09:15:56','2023-02-13 09:15:56');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('62','105','','','100','2023-02-13 09:16:48','2023-02-13 09:16:48');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('63','105','62','On Supply & Delivery','70','2023-02-13 09:16:48','2023-02-13 09:16:48');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('64','105','62','On Completion/Erection/Fixing/Laying/Jointing','20','2023-02-13 09:16:48','2023-02-13 09:16:48');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('65','105','62','On Completion of Testing','5','2023-02-13 09:16:48','2023-02-13 09:16:48');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('66','105','62','On Commissioning','5','2023-02-13 09:16:48','2023-02-13 09:16:48');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('67','118','','','100','2023-02-13 09:17:31','2023-02-13 09:17:31');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('68','118','67','On completion of work','100','2023-02-13 09:17:31','2023-02-13 09:17:31');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('69','117','','','100','2023-02-13 09:17:53','2023-02-13 09:17:53');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('70','117','69','On completion of work','100','2023-02-13 09:17:53','2023-02-13 09:17:53');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('71','106','','','100','2023-02-13 09:20:56','2023-02-13 09:20:56');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('72','106','71','On Supply & Delivery','70','2023-02-13 09:20:56','2023-02-13 09:20:56');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('73','106','71','On Completion/Erection/Fixing/Laying/Jointing','20','2023-02-13 09:20:56','2023-02-13 09:20:56');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('74','106','71','On Completion of Testing','5','2023-02-13 09:20:56','2023-02-13 09:20:56');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('75','106','71','On Commissioning','5','2023-02-13 09:20:56','2023-02-13 09:20:56');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('76','109','','','100','2023-02-13 09:21:36','2023-02-13 09:21:36');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('77','109','76','On completion of job','100','2023-02-13 09:21:36','2023-02-13 09:21:36');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('78','110','','','100','2023-02-13 09:22:07','2023-02-13 09:22:07');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('79','110','78','On Supply & Delivery of Solar Panel System','70','2023-02-13 09:22:07','2023-02-13 09:22:07');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('80','110','78','Completion of Erection of  Solar Panel System','20','2023-02-13 09:22:07','2023-02-13 09:22:07');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('81','110','78','On Completion of Testing','5','2023-02-13 09:22:07','2023-02-13 09:22:07');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('82','110','78','On Commissioning','5','2023-02-13 09:22:07','2023-02-13 09:22:07');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('83','108','','','100','2023-02-13 09:22:27','2023-02-13 09:22:27');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('84','108','83','On Commissioning','5','2023-02-13 09:22:27','2023-02-13 09:22:27');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('85','108','83','On Completion of Testing','5','2023-02-13 09:22:27','2023-02-13 09:22:27');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('86','108','83','On Completion/Erection/Fixing/Laying/Jointing','20','2023-02-13 09:22:27','2023-02-13 09:22:27');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('87','108','83','On Supply & Delivery','70','2023-02-13 09:22:27','2023-02-13 09:22:27');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('88','116','','','100','2023-02-13 09:22:45','2023-02-13 09:22:45');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('89','116','88','On completion of work','100','2023-02-13 09:22:45','2023-02-13 09:22:45');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('90','107','','','100','2023-02-13 09:22:53','2023-02-13 09:22:53');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('91','107','90','On Supply & Delivery','70','2023-02-13 09:22:53','2023-02-13 09:22:53');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('92','107','90','On Completion/Erection/Fixing/Laying/Jointing','20','2023-02-13 09:22:53','2023-02-13 09:22:53');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('93','107','90','On Completion of Testing','5','2023-02-13 09:22:53','2023-02-13 09:22:53');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('94','107','90','On Commissioning','5','2023-02-13 09:22:53','2023-02-13 09:22:53');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('95','115','','','100','2023-02-13 09:29:09','2023-02-13 09:29:09');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('96','115','95','On completion of work','100','2023-02-13 09:29:09','2023-02-13 09:29:09');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('97','114','','','100','2023-02-13 09:29:28','2023-02-13 09:29:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('98','114','97','On completion of work','100','2023-02-13 09:29:28','2023-02-13 09:29:28');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('99','113','','','100','2023-02-13 09:30:07','2023-02-13 09:30:07');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('100','113','99','Supply of MS Gate','70','2023-02-13 09:30:07','2023-02-13 09:30:07');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('101','113','99','Erection/Fixing of MS Gate','30','2023-02-13 09:30:07','2023-02-13 09:30:07');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('102','112','','','100','2023-02-13 09:30:33','2023-02-13 09:30:33');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('103','112','102','Supply of MS Gate','70','2023-02-13 09:30:33','2023-02-13 09:30:33');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('104','112','102','Erection/Fixing of MS Gate','30','2023-02-13 09:30:33','2023-02-13 09:30:33');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('105','111','','','100','2023-02-13 09:38:05','2023-02-13 09:38:05');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('106','111','105','Excavation of Boundary wall Foundation','10','2023-02-13 09:38:05','2023-02-13 09:38:05');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('107','111','105','PCC for Foundation','10','2023-02-13 09:38:05','2023-02-13 09:38:05');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('108','111','105','Supply of raw material/Precast panel','50','2023-02-13 09:38:05','2023-02-13 09:38:05');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('109','111','105','Construction of wall/Precast panel erection','20','2023-02-13 09:38:05','2023-02-13 09:38:05');

INSERT INTO item_details (id, item_id, parent_id, name, percentage, created_at, updated_at) VALUES ('110','111','105','Finishing & other work','10','2023-02-13 09:38:05','2023-02-13 09:38:05');


CREATE TABLE `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO units (id, name, created_at, updated_at) VALUES ('1','LS','2023-02-13 09:01:54','2023-02-13 09:01:54');
