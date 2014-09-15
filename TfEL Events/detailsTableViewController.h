//
//  detailsTableViewController.h
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 9/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>

@interface detailsTableViewController : UITableViewController <MKMapViewDelegate>

@property (strong, nonatomic) IBOutlet MKMapView *mapViewOutlet;

@property (strong, nonatomic) IBOutlet UILabel *titleOutlet;
@property (strong, nonatomic) IBOutlet UILabel *whenFromOutlet;
@property (strong, nonatomic) IBOutlet UILabel *whenToOutlet;
@property (strong, nonatomic) IBOutlet UILabel *whereOutlet;
@property (strong, nonatomic) IBOutlet UILabel *costOutlet;
@property (strong, nonatomic) IBOutlet UILabel *cateringOutlet;

@end
