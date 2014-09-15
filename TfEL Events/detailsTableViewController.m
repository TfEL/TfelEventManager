//
//  detailsTableViewController.m
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 9/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import "detailsTableViewController.h"

#import "AppDelegate.h"

#define AppDelegate ((AppDelegate *)[UIApplication sharedApplication].delegate)


@interface detailsTableViewController ()

@end

@interface AnnotationDelegate : NSObject <MKAnnotation> {
    CLLocationCoordinate2D coordinate;
    NSString * title;
    NSString * subtitle;
}

@end

@implementation detailsTableViewController

@synthesize mapViewOutlet, titleOutlet, whenFromOutlet, whenToOutlet, whereOutlet, costOutlet, cateringOutlet, tableView;

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
    
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    titleOutlet.text = AppDelegate.eventName;
    whenFromOutlet.text = AppDelegate.whenFrom;
    whenToOutlet.text = AppDelegate.whenTo;
    whereOutlet.text = AppDelegate.where;
    costOutlet.text = AppDelegate.cost;
    cateringOutlet.text = AppDelegate.catering;
    
    NSString *location = AppDelegate.where;
    CLGeocoder *geocoder = [[CLGeocoder alloc] init];
    [geocoder geocodeAddressString:location
                 completionHandler:^(NSArray* placemarks, NSError* error){
                     if (placemarks && placemarks.count > 0) {
                         CLPlacemark *topResult = [placemarks objectAtIndex:0];
                         MKPlacemark *placemark = [[MKPlacemark alloc] initWithPlacemark:topResult];
                         
                         MKCoordinateRegion region = self.mapViewOutlet.region;
                         region.center = [(CLCircularRegion *)placemark.region center];
                         region.span.longitudeDelta /= 2800;
                         region.span.latitudeDelta /= 2800;
                         
                         [self.mapViewOutlet setRegion:region animated:YES];
                         [self.mapViewOutlet addAnnotation:placemark];
                     }
                 }
     ];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
