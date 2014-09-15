//
//  eventsListTableViewController.m
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 9/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import "eventsListTableViewController.h"
#import "AFNetworking.h"
#import "JSONResponseSerializerWithData.h"
#import "eventDataObject.h"

#import "AppDelegate.h"

#define AppDelegate ((AppDelegate *)[UIApplication sharedApplication].delegate)


@interface eventsListTableViewController ()

@end

@implementation eventsListTableViewController

@synthesize returnedJson, tableView, offlineButtonOutlet;

-(void)loadDataFromServer {
    
    // NSURLRequest *request = [NSURLRequest requestWithURL:[NSURL URLWithString:@"https://justpast:midnight@events.tfel.edu.au/api/listClasses.php"]];
    
    NSData *data = [NSData dataWithContentsOfURL: [NSURL URLWithString:@"https://justpast:midnight@events.tfel.edu.au/api/listClasses.php"]];
    
    if (!data) {
        [self createErrorMessageWithLabel:@"Working Offline" :@"You appear to be offline, and your events may not be up-to-date."];
    } else {
        AppDelegate.events = data;
    }
    /* [NSURLConnection sendAsynchronousRequest:request
                                       queue:[NSOperationQueue mainQueue]
                           completionHandler:^(NSURLResponse *response, NSData *data, NSError *error) {
                               AppDelegate.events = data;
                           }]; */
}

- (BOOL)connected {
    return [AFNetworkReachabilityManager sharedManager].reachable;
}

-(void)setupEventsFromJSONArray:(NSData*)dataFromServerArray{
    NSError *error = nil;
    NSArray *arrayFromServer;
    if (!dataFromServerArray) {
        eventsArray = [[NSMutableArray alloc] init];
    } else {
        arrayFromServer = [NSJSONSerialization JSONObjectWithData:dataFromServerArray options:0 error:&error];
        eventsArray = [[NSMutableArray alloc] init];
    }
    if(error){
        NSLog(@"Error parsing the json data from server with error description - %@", [error localizedDescription]);
    }
    else {
        for(NSDictionary *eachEvent in arrayFromServer) {
            eventDataObject *event = [[eventDataObject alloc] initWithJSONData:eachEvent];
            [eventsArray addObject:event];
            NSLog(@"Total event count: %lu", (unsigned long)[eventsArray count]);
        }
        
    }
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    NSLog(@"numberOfRowsInSection returning %lu", (unsigned long)[eventsArray count]);
    return [eventsArray count];
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath*)indexPath {
    AppDelegate.eventidentifier = [[eventsArray objectAtIndex:indexPath.row] eventidentifier];
    AppDelegate.eventName = [[eventsArray objectAtIndex:indexPath.row] eventName];
    AppDelegate.whenFrom = [[eventsArray objectAtIndex:indexPath.row] whenFrom];
    AppDelegate.whenTo = [[eventsArray objectAtIndex:indexPath.row] whenTo];
    AppDelegate.whenStart = [[eventsArray objectAtIndex:indexPath.row] whenStart];
    AppDelegate.where = [[eventsArray objectAtIndex:indexPath.row] where];
    AppDelegate.cost = [[eventsArray objectAtIndex:indexPath.row] cost];
    AppDelegate.catering = [[eventsArray objectAtIndex:indexPath.row] catering];
    AppDelegate.detailsURL = [[eventsArray objectAtIndex:indexPath.row] detailsURL];
}

- (void) reachabilityMonitor {
    NSLog(@"Hit");
    if ([self connected] == NO) {
        offlineButtonOutlet.tintColor = [UIColor redColor];
        offlineButtonOutlet.enabled = YES;
    } else {
        offlineButtonOutlet.tintColor = [UIColor clearColor];
        offlineButtonOutlet.enabled = NO;
    }
}


-(UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *simpleTableIdentifier = @"basic";
    
    UITableViewCell *cell = [self.tableView dequeueReusableCellWithIdentifier:simpleTableIdentifier];
    
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:simpleTableIdentifier];
    }
    
    if([eventsArray count] == 0){
        cell.textLabel.text = @"No events to display...";
        NSLog(@"No results");
    }
    
    else {
        eventDataObject *currentEvent = [eventsArray objectAtIndex:[indexPath row]];
        //UILabel *classLabel = (UILabel *)[cell viewWithTag:0];
        cell.textLabel.text = [currentEvent eventName];
        cell.detailTextLabel.text = [currentEvent whenStart];
    }
    
    return cell;
}


-(void)createErrorMessageWithLabel:(NSString *)title :(NSString *)body {
    [[[UIAlertView alloc] initWithTitle:title message:body delegate:self cancelButtonTitle:@"Okay" otherButtonTitles: nil] show];
}

- (void)viewWillAppear:(BOOL)animated {
    
    offlineButtonOutlet.tintColor = [UIColor clearColor];
    offlineButtonOutlet.enabled = NO;
    
    /* NSTimeInterval delay = 4.5; //in seconds
    [self performSelector:@selector(reachabilityMonitor) withObject:nil afterDelay:delay]; */
    
    [[AFNetworkReachabilityManager sharedManager] startMonitoring];
    
    NSOperationQueue *myQueue = [[NSOperationQueue alloc] init];
    
    [myQueue addOperationWithBlock:^{
        
        [self loadDataFromServer];
        
        NSData *returnedData = AppDelegate.events;
        
        [[NSOperationQueue mainQueue] addOperationWithBlock:^{
            [self setupEventsFromJSONArray:returnedData];
            
            [self.tableView reloadData];
        }];
    }];
    
    [tableView deselectRowAtIndexPath:[tableView indexPathForSelectedRow] animated:animated];
    
}

- (void)viewDidLoad
{
    [super viewDidLoad];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

- (IBAction)refreshRequested:(id)sender {
    NSLog(@"Refresh Requested");
    
    NSData *returnedData = [NSData dataWithContentsOfURL: [NSURL URLWithString:@"https://justpast:midnight@events.tfel.edu.au/api/listClasses.php"]];
    
    if (!returnedData) {
        NSLog(@"No returned data");
    }
    
    //[self.tableView reloadData];
    
    [self setupEventsFromJSONArray:returnedData];
    
    [self.tableView reloadData];
    
    [sender endRefreshing];
}

- (IBAction)offlineButton:(id)sender {
    [self createErrorMessageWithLabel:@"Working Offline" :@"You appear to be offline, and your events may not be up-to-date."];
}
@end
