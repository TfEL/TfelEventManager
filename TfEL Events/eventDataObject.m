//
//  eventDataObject.m
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 9/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import "eventDataObject.h"

@implementation eventDataObject

@synthesize eventidentifier, eventName, whenFrom, whenStart, whenTo, where, cost, catering, detailsURL;

-(id)initWithJSONData:(NSDictionary*)data{
    self = [super init];
    if(self) {
        //NSLog(@"Teacher Data: initWithJSONData Called");
        
        self.eventidentifier = [[data objectForKey:@"id"] integerValue];
        
        self.eventName = [data objectForKey:@"name"];
        
        self.whenFrom = [data objectForKey:@"when_from"];
        
        self.whenTo = [data objectForKey:@"when_to"];
        
        self.whenStart = [data objectForKey:@"start"];
        
        self.where = [data objectForKey:@"where"];
        
        self.cost = [data objectForKey:@"cost"];
        
        self.catering = [data objectForKey:@"catering"];
        
        self.detailsURL = [data objectForKey:@"detailsURL"];
    }
    return self;
}


@end
